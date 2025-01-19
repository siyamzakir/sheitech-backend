<?php

namespace Modules\Api\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\FeatureTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;

class AccessoryDetailsResource extends JsonResource
{
    use ProductTrait;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'slug'                 => $this->slug,
            'image'                => asset('storage/' . $this->image_url),
            'price'                => $this->price,
            'discount_rate'        => $this->discount_rate,
            'price_after_discount' => $this->calculateDiscountPrice($this->price, $this->discount_rate),
            'in_stock'             => $this->total_stock,
            'brand'                => new BrandResource($this->brand),
            'category'             => new CategoryResource($this->category),
            'colors'               => ColorResource::collection($this->colors),
            'media'                => MediaResource::collection($this->media),
            'short_description'    => $this->short_description,
            'description'          => $this->description,
        ];
    }
}
