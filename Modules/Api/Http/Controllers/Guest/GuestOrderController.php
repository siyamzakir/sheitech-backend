<?php

namespace Modules\Api\Http\Controllers\Guest;

use App\Http\Controllers\AmarPayController;
use App\Http\Controllers\Controller;
use App\Models\GuestCart;
use App\Models\GuestOrder;
use App\Models\GuestOrderDetails;
use App\Models\GuestUser;
use App\Models\Order\Cart;
use App\Models\OrderDetails;
use App\Models\Product\Product;
use App\Models\Product\ProductColor;
use App\Models\ProductFeatureValue;
use App\Models\System\Area;
use App\Models\System\City;
use App\Models\System\DeliveryOption;
use App\Models\System\Division;
use App\Models\System\Notification;
use App\Models\System\PaymentMethod;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Api\Http\Requests\Guest\GuestOrderRequest;
use Modules\Api\Http\Traits\Order\OrderTrait;
use Modules\Api\Http\Traits\OTP\OtpTrait;
use Modules\Api\Http\Traits\Response\ApiResponseHelper;
use Session;

class GuestOrderController extends Controller
{
    use ApiResponseHelper;
    use OrderTrait;
    use OtpTrait;


    public function guestOrder(GuestOrderRequest $request)
    {
        if (isset($request->guest_cart_id)) {
            $order = $this->buyNowFromCart($request);
        } else {
            $order = $this->buyNow($request);
        }
        return $order;
    }

    public function buyNow($request)
    {
        DB::beginTransaction();
        try {
            $product_feature_id = [];
            if (isset($request->product_feature_id)) {
                $product_feature_id = json_decode($request->product_feature_id);
            }

            $product = Product::with(['productFeatureValues', 'colors'])->where('id', $request->product_id)->first();

            $price = $product->price + $product->productFeatureValues->whereIn('id', $product_feature_id)->sum('price') + $product->colors->whereIn('id', $request->product_color_id)->sum('price');
            $subtotal_price = $this->calculateDiscountPrice($price, $product->discount_rate) * $request->quantity;

            if ($request->product_color_id) {
                $product_color = ProductColor::find($request->product_color_id);
                if ($product_color) {
                    if ($product_color->stock > 0) {
                        $product_color->update([
                            'stock' => $product_color->stock - $request->quantity
                        ]);
                    } else {
                        return $this->respondError(
                            'Product is out of stock'
                        );
                    }
                }
            }

            if ($request->product_feature_id) {
                $product_feature = ProductFeatureValue::WhereIn('id', json_decode($request->product_feature_id))->get();
                foreach ($product_feature as $f) {
                    if ($f->stock > 0) {
                        $f->stock = $f->stock - $request->quantity;
                        $f->save();
                    } else {
                        return $this->respondError(
                            'Product feature is out of stock'
                        );
                    }
                }
            }

            if (!empty($request['voucher_id'])) {
                $voucher_dis = $this->calculateVoucherDiscount($request['voucher_id'], $subtotal_price);
                $subtotal_price = $subtotal_price - $voucher_dis;
            }

            $total_price = $subtotal_price + $request->shipping_amount;
            $order_key = now()->format('Ymd') . '-' . GuestOrder::count() + 1;

            $city = City::where('id', $request->city_id)->first()->name;
            $area = Area::where('id', $request->area_id)->first()->name;
            $division = Division::where('id', $request->division_id)->first()->name;

            $orderData = [
                'transaction_id' => $order_key,
                'order_key' => $order_key,
                'discount_rate' => $product->discount_rate ?? 0,
                'shipping_amount' => $request->shipping_amount,
                'subtotal_price' => $subtotal_price,
                'total_price' => $total_price,
                'name' => $request->name,
                'phone_number' => $request->phone,
                'email' => $request->email ?? null,
                'city' => $city,
                'division' => Division::where('id', $request->division_id)->first()->name,
                'area' => $area,
                'address_line' => $request->address_line,
                'delivery_option' => DeliveryOption::where('id', $request->delivery_option_id)->first()->name,
                'payment_method' => PaymentMethod::where('id', $request->payment_method_id)->first()->name,
                'order_note' => $request->order_note ?? null,
                'voucher_code' => $request->voucher_code ?? null,
            ];

            $order = GuestOrder::create($orderData);


            if ($order) {

                $orderDetails = [
                    'guest_order_id' => $order->id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'product_color_id' => $request->product_color_id ?? null,
                    'feature' => $request->product_feature_id ?? null,
                    'price' => $price,
                    'discount_rate' => $product->discount_rate ?? 0,
                    'subtotal_price' => $subtotal_price,
                ];

                GuestOrderDetails::create($orderDetails);

                $sslc = new AmarPayController();
                if ($request->payment_method_id == 2) {
                    if ($isProcessPayment = $sslc->payment($orderData)) {
                        DB::commit();
                        return [
                            'status' => 'success',
                            'message' => 'Payment Successful',
                            'data' => $isProcessPayment->getTargetUrl()
                        ];
                    } else {
                        return [
                            'status' => false,
                            'message' => 'Order Unsuccessful',
                        ];
                    }
                } else {
                    DB::commit();
                    $numbers = Notification::where('status', 1)->get();
                    foreach ($numbers as $number) {
                        $this->sendSms(strtr($number->phone, [' ' => '']), "New order has been placed with the order number: " . $order->order_key . "  Please check your dashboard");
                    }

                    Http::withHeaders([
                        'Api-Key' => env('STEADFAST_API_KEY'),
                        'Secret-Key' => env('STEADFAST_API_SECRET'),
                        'Content-Type' => 'application/json'
                    ])->post('https://portal.steadfast.com.bd/api/v1/create_order',[
                        'invoice' => $order->order_key,
                        'recipient_name' => $request->name,
                        'recipient_phone' => $request->phone,
                        'recipient_address' => 'City: ' . $city . ', Area: ' . $area . ', Address: ' . $request->address_line . ' Division : ' .  $division,
                        'cod_amount' => $total_price,
                        'note' => $order->order_note ?? null
                    ]);

                    $message = "Hi! " . $request->name . ".  Your order has been placed successfully. Your order number is " . $order->order_key . " Total " . $total_price . " BDT.  Thank you for shopping from hellotech.store";
                    $this->sendSms($request->phone, $message);

                    return [
                        'status' => true,
                        'message' => 'Order Successful',
                        'data' => [
                            'order_id' => $order->id,
                            'transaction_id' => $order->transaction_id,
                            'order_key' => $order->order_key,
                            'total' => $total_price ?? 0,
                        ]
                    ];
                }
            } else {
                DB::rollBack();
                return $this->respondError(
                    'Something went wrong'
                );
            }
        } catch (\Exception $e) {
            return $this->respondError(
                $e->getMessage()
            );
        }
    }

    public function buyNowFromCart($request)
    {
        DB::beginTransaction();
        try {

            $guest = GuestUser::where('uuid', $request->guest_user_id)->first();
            $guestCarts = GuestCart::where('guest_user_id', $guest->id)->where('status', 1);
            $carts = $guestCarts->get();
            $orderDetails = [];

            // check carts is empty
            if ($carts->isEmpty()) {
                throw new \Exception('Cart is empty.');
            }

            foreach ($carts as $cartItem) {

                $featurePrice = 0;
                $product_feature_id = [];
                $product = Product::with(['productFeatureValues', 'colors'])->where('id', $cartItem['product_id'])->first();

                if (isset($cartItem['product_data'])) {
                    $product_feature_id = json_decode($cartItem['product_data']);
                    $featurePrice = $product->productFeatureValues->whereIn('id', $product_feature_id)->sum('price') ?? 0;
                }

                $price = $product->price + $featurePrice + $product->colors->whereIn('id', $cartItem->product_color_id)->sum('price');
                $subtotal_price = $this->calculateDiscountPrice($price, $product->discount_rate) * $cartItem['quantity'];

                // product color price
                $product_color = $product->colors->whereIn('id', $cartItem->product_color_id)->first();
                if ($product_color) {
                    if ($product_color->stock < $cartItem['quantity']) {
                        throw new \Exception('Product color out of stock.');
                    }
                    $product_color->stock = $product_color->stock - $cartItem['quantity'];
                    $product_color->save();
                }

                if (!empty($cartItem['product_data'])) {
                    $product_features = $product_feature_id;
                    foreach ($product_features as $f) {
                        $productFeatureValue = ProductFeatureValue::find($f);
                        if ($productFeatureValue['stock'] < $cartItem['quantity']) {
                            throw new \Exception('Feature Product out of stock.');
                        }
                        $productFeatureValue->stock = $productFeatureValue['stock'] - $cartItem['quantity'];
                        $productFeatureValue->save();
                    }
                }

                $orderDetails[] = [
                    'product_id' => $cartItem['product_id'],
                    'product_color_id' => $cartItem['product_color_id'],
                    'feature' => $cartItem['product_data'] ?? null,
                    'price' => $price ?? 0,
                    'quantity' => $cartItem['quantity'] ?? 0,
                    'discount_rate' => $product->discount_rate ?? 0,
                    'subtotal_price' => $subtotal_price ?? 0,
                ];
            }

            $subtotal_price = collect($orderDetails)->sum('subtotal_price');

            if (!empty($request['voucher_id'])) {
                $voucher_dis = $this->calculateVoucherDiscount($request['voucher_id'], $subtotal_price);
                $subtotal_price = $subtotal_price - $voucher_dis;
            }
            $total_price = $subtotal_price + $request->shipping_amount;
            $order_key = now()->format('Ymd') . '-' . GuestOrder::count() + 1;
            $city = City::where('id', $request->city_id)->first()->name;
            $area = Area::where('id', $request->area_id)->first()->name;
            $division = Division::where('id', $request->division_id)->first()->name;
            $orderData = [
                'transaction_id' => $order_key,
                'order_key' => $order_key,
                'discount_rate' => $product->discount_rate ?? 0,
                'shipping_amount' => $request->shipping_amount,
                'subtotal_price' => $subtotal_price,
                'total_price' => $subtotal_price + $request->shipping_amount,
                'name' => $request->name,
                'phone_number' => $request->phone,
                'email' => $request->email ?? null,
                'city' => $city,
                'division' => $division,
                'area' => $area,
                'address_line' => $request->address_line,
                'delivery_option' => DeliveryOption::where('id', $request->delivery_option_id)->first()->name,
                'payment_method' => PaymentMethod::where('id', $request->payment_method_id)->first()->name,
                'order_note' => $request->order_note ?? null,
                'voucher_code' => $request->voucher_code ?? null,
            ];

            $order = GuestOrder::create($orderData);

            if ($order) {

                // add `order_id` to orderDetails
                $orderDetails = array_map(function ($item) use ($order) {
                    $item['guest_order_id'] = $order->id;
                    return $item;
                }, $orderDetails);

                GuestOrderDetails::insert($orderDetails);
                $guestCarts->delete();

                $sslc = new AmarPayController();
                if ($request->payment_method_id == 2) {
                    if ($isProcessPayment = $sslc->payment($orderData)) {
                        DB::commit();
                        return [
                            'status' => 'success',
                            'message' => 'Payment Successful',
                            'data' => $isProcessPayment->getTargetUrl()
                        ];
                    } else {
                        return [
                            'status' => false,
                            'message' => 'Order Unsuccessful',
                        ];
                    }
                } else {
                    $numbers = Notification::where('status', 1)->get();
                    foreach ($numbers as $number) {
                        $this->sendSms(strtr($number->phone, [' ' => '']), "New order has been placed with the order number: " . $order->order_key . "  Please check your dashboard");
                    }
                    Http::withHeaders([
                        'Api-Key' => env('STEADFAST_API_KEY'),
                        'Secret-Key' => env('STEADFAST_API_SECRET'),
                        'Content-Type' => 'application/json'
                    ])->post('https://portal.steadfast.com.bd/api/v1/create_order',[
                        'invoice' => $order->order_key,
                        'recipient_name' => $request->name,
                        'recipient_phone' => $request->phone,
                        'recipient_address' => 'City: ' . $city . ', Area: ' . $area . ', Address: ' . $request->address_line . ' Division: ' .  $division,
                        'cod_amount' => $total_price,
                        'note' => $order->order_note ?? null
                    ]);
                    $message = "Hi! " . $request->name . ".  Your order has been placed successfully. Your order number is " . $order->order_key . " Total " . $total_price . " BDT.  Thank you for shopping from hellotech.store";
                    $this->sendSms($request->phone, $message);
                    DB::commit();
                    return [
                        'status' => true,
                        'message' => 'Order Successful',
                        'data' => [
                            'order_id' => $order->id,
                            'transaction_id' => $order->transaction_id,
                            'order_key' => $order->order_key,
                            'total' => $total_price ?? 0,
                        ]
                    ];
                }
            } else {
                DB::rollBack();
                return $this->respondError(
                    'Something went wrong'
                );
            }
        } catch (\Exception $e) {
            return (
            [
                $e->getMessage(),
                $e->getLine(),
            ]
            );
        }

    }
}
