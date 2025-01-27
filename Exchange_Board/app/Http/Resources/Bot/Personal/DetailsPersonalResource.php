<?php

namespace App\Http\Resources\Bot\Personal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailsPersonalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'online'=>$this->online,
            'details_market_to'=>$this->details_market_to,
            'name_method'=>$this->name_method,
            'comment'=>$this->comment
        ];
    }
}
