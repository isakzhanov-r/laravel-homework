<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Product */
class ProductResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'price'    => $this->price,
            'quantity' => $this->pivot->quantity,
            'vendor'   => new VendorResource($this->whenLoaded('vendor')),
        ];
    }
}
