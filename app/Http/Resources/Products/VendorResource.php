<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Vendor */
class VendorResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'email' => $this->email,
            'name'  => $this->name,
        ];
    }
}
