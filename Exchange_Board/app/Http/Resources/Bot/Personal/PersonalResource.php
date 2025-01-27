<?php

namespace App\Http\Resources\Bot\Personal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'hash_id'=>$this->hash_id,
            'status'=>$this->status,
            'balance'=>$this->balance,
            'details_from'=>$this->details_from,
            'private_key'=>$this->private_key,
            'details_to'=>$this->details_to
        ];
    }
}
