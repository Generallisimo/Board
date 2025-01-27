<?php

namespace App\Http\Resources\Bot\Personal\Details;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'online'=>$this->online,
            'details_market_to'=>$this->details_market_to,
            'name_method'=>$this->name_method,
            'currency'=>$this->currency,
            'comment'=>$this->comment,
        ];
    }
}
