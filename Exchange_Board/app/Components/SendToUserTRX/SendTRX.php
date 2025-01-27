<?php

namespace App\Components\SendToUserTRX;

use Illuminate\Support\Facades\Http;

class SendTRX
{
    public $addressTo;
    public $ownerAddress;
    public $privateKey;
    public $amount;

    public function __construct($addressTo, $amount)
    {
        $this->addressTo = $addressTo;
        $this->amount = $amount;
        $this->ownerAddress = config('wallet.wallet');
        $this->privateKey = config('wallet.private_key');
    }
    
    public function sendTRX(){
        $tronHost = config('tron.host'); 

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($tronHost . '/sendTronTRX', [
            'addressTo' => $this->addressTo,
            'amount' => $this->amount,
            'ownerAddress' => $this->ownerAddress,
            'privateKey' => $this->privateKey,
        ]);

        if ($response->successful()) {
            return true;
        } else {
            return $response->body();
        }
    }
}