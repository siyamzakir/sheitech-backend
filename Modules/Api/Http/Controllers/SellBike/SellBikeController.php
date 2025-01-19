<?php

namespace Modules\Api\Http\Controllers\SellBike;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Api\Http\Requests\Sell\SellBikeRequest;
use Modules\Api\Http\Resources\SellBike\BikeResource;
use Modules\Api\Http\Traits\SellBike\SellBikeTrait;

class SellBikeController extends Controller
{
    use SellBikeTrait;

    public function bikeByBrand($brand_id)
    {
        return $this->respondWithSuccessWithData(
            BikeResource::collection($this->getBikeByBrand($brand_id))
        );
    }

    public function store(SellBikeRequest $request)
    {
        $this->storeSellBike($request);
        return $this->respondWithSuccess([
            'message' => 'Bike sell request has been submitted successfully'
        ]);
    }
}
