<?php

namespace Modules\Api\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\FeatureTrait;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => ucwords(strtolower($this->name)),
            'slug'      => $this->slug,
            'icon'      => str_contains($this->icon, 'http') ? $this->icon : asset('storage/' . $this->icon),
            'count'     => $this->products->count(),
            'image_url' => str_contains($this->image_url, 'http') ? $this->image_url : asset('storage/' . $this->image_url),
            'sub_categories' => SubCategoryResource::collection($this->whenLoaded('subCategories')),
        ];
    }
}
