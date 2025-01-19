<?php

namespace Modules\Api\Http\Resources\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
class ProductCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'products' => $this->collection,
            'meta'      => [
                'total'        => $this->total(),
                'count'        => $this->count(),
                'per_page'     => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages'  => $this->lastPage()
            ]
        ];
    }
}
