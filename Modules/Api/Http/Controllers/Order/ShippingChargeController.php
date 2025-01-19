<?php

namespace Modules\Api\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use App\Models\System\DeliveryOption;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShippingChargeController extends Controller
{
    public function shippingCharges($name = null)
    {
        $text = strtolower($name);
        if ($text == 'dhaka') {
            $shipping_charge = DeliveryOption::where('name', '=', 'Inside Dhaka')->first();
        } else {
            $shipping_charge = DeliveryOption::whereNotIn('name', ['Inside Dhaka'])->first();
        }

        return response()->json([
            'status' => 'success',
            'data' => $shipping_charge
        ]);
    }


//        try {
//            $text = strtolower($name);
//            if ($text == 'dhaka') {
//                $shipping_charge = DeliveryOption::where('name', '=', 'Inside Dhaka')->first();
//            } else {
//                $shipping_charge = DeliveryOption::whereNotIn('name', ['Inside Dhaka'])->first();
//            }
//            return response()->json([
//                'status' => 'success',
//                'data' => $shipping_charge
//            ]);
//        } catch (\Exception $e) {
//            return response()->json([
//                'status' => 'error',
//                'message' => $e->getMessage()
//            ]);
//        }
}

