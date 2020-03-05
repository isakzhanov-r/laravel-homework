<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Product */
class ProductResource extends JsonResource
{
    protected $message;

    public function __construct($resource, $message)
    {
        $this->message = $message;

        parent::__construct($resource);
    }

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
            'quantity' => $this->whenPivotLoaded('order_products', function () {
                return $this->pivot->quantity;
            }),
            'vendor'   => new VendorResource($this->whenLoaded('vendor')),
        ];
    }

    public function with($request)
    {
        return $this->message
            ? ['message' => $this->message]
            : [];
    }
}
