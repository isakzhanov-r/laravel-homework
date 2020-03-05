<?php

namespace App\Http\Resources\Partners;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Partner */
class PartnerResource extends JsonResource
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
