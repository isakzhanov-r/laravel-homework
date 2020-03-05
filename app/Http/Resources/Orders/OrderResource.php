<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\Partners\PartnerResource;
use App\Http\Resources\Products\ProductResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Order */
class OrderResource extends JsonResource
{
    protected $message;

    public function __construct($resource, $message = null)
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
            'id'           => $this->id,
            'status'       => $this->status,
            'client_email' => $this->client_email,
            'delivery_at'  => Carbon::parse($this->delivery_at)->isoFormat('MMMM Do YYYY, h:mm:ss a'),
            'partner'      => new PartnerResource($this->whenLoaded('partner')),
            'products'     => ProductResource::collection($this->whenLoaded('products')),
        ];
    }

    public function with($request)
    {
        return $this->message
            ? ['message' => $this->message]
            : [];
    }
}
