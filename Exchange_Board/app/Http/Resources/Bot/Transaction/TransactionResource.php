<?php

namespace App\Http\Resources\Bot\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'exchange_id'=>$this->exchange_id,
            'amount_users'=>$this->amount_users,
        ];
    }
}
