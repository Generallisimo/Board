<?php

namespace App\Components\SendToUserTRON;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendTRON{

    public $amount;
    public $addressTo;
    public $ownerAddress;
    public $ownerKey;

    public function __construct($amount, $addressTo, $ownerAddress, $ownerKey)
    {
        $this->amount = $amount;
        $this->addressTo = $addressTo;
        $this->ownerAddress = $ownerAddress;
        $this->ownerKey = $ownerKey;
    }
    
    public function send(){
        $tronHost = config('tron.host'); 
        Log::info('getParamSend', [$this->amount, $this->addressTo, $this->ownerAddress, $this->ownerKey]);
        try{
            $urlSend = $tronHost . '/sendTronUSDT';

            $amountInSun = $this->amount * '1000000';
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
                ])->post($urlSend, [
                    'addressTo' => $this->addressTo,
                    'amount' => $amountInSun,
                    'ownerAddress' => $this->ownerAddress,
                    'privateKey' => $this->ownerKey,
                ]);

            $data = $response->json();
            if($data['transactionHash']){
                return [
                    'success'=>true,
                    'message'=>$data['transactionHash']
                ];
            }else{
                return [
                    'success'=>false,
                    'message'=>'Ошибка перевода, обратитесь в поддержку'
                ];
            }
        }catch(Exception $e){
            return [
                'success'=>false,
                'message'=>'Ошибка соеденения'.$e->getMessage()
            ];
        }
    }
}