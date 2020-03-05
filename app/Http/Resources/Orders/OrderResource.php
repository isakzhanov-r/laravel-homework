<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\Partners\PartnerResource;
use App\Http\Resources\Products\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Order */
class OrderResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'status'       => $this->status,
            'client_email' => $this->client_email,
            'delivery_at'  => $this->delivery_at,
            'partner'      => new PartnerResource($this->whenLoaded('partner')),
            'products'     => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
