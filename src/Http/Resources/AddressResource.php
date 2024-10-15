<?php

namespace RiseTech\Address\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "zip_code" => $this->zip_code,
            "country" => $this->country,
            "state" => $this->state,
            "city" => $this->city,
            "district" => $this->district,
            "address" => $this->address,
            "number" => $this->number,
            "complement" => $this->complement,
        ];
    }
}
