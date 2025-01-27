<?php

namespace App\Components\CheckTXID;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckTXID
{
    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function check(){
        $tronHost = config('tron.host'); 

        $url = $tronHost . '/check_txid';
        
        $response = Http::timeout(300)->post($url, [
            'transactionHash'=>$this->transaction
        ]);
        $data = $response->json();
        Log::info("Из контроллера CheckTXID получаем ответ от node", ['response' => json_encode($data)]);
        if($data['success'] === true){
            return ['success'=>true];
        }elseif($data['success'] === false){
            return ['success'=>false];
        }
    }
}