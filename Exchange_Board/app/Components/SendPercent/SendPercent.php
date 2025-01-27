<?php

namespace App\Components\SendPercent;

use App\Components\CheckTXID\CheckTXID;
use App\Components\SendToUserTRON\SendTRON;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendPercent
{
    public $amount;
    public $details_to;
    public $details_from;
    public $private_key;

    public function __construct($amount, $details_to, $details_from, $private_key)
    {
        $this->amount = $amount;
        $this->details_to = $details_to;
        $this->details_from = $details_from;
        $this->private_key = $private_key;
    }

    public function update(){
        $startTime = time();
        $timeUot = 300;

        $send = (new SendTRON(
            $this->amount, 
            $this->details_to, 
            $this->details_from, 
            $this->private_key
            ))->send();
        
        $checkTXID = (new CheckTXID($send['message']));
        Log::info('Получает в sendPercent 1 или 2', ['transaction' => $send['message']]);
        $isSuccessful = false;

        while(time() - $startTime < $timeUot){
            $result = $checkTXID->check();
            Log::info('Получаем ответ от result', ['success' => $result['success']]);
            if($result['success'] === true){
                $isSuccessful = true;
                Log::info('Получаем в цикле isSuc', ['isSuccessful' => $isSuccessful]);
                break;
            }else if($result['success'] === false){
                $isSuccessful = false;
                Log::info('Получаем в цикле isSuc', ['isSuccessful' => $isSuccessful]);
                break;
            }

            sleep(10);
        }

        if($isSuccessful){
            Log::info('send success true');
            return [
                'success'=>true,
                'message'=>'successful transaction',
                'transaction'=>$send['message'],
                'owner'=>$this->details_from,
                'address_to'=>$this->details_to,
                'amount'=>$this->amount
            ];
        }else{
            Log::info('send success false');
            return [
                'success'=>false,
                'message'=>'error with transaction',
                'transaction'=>$send['message'],
                'owner'=>$this->details_from,
                'address_to'=>$this->details_to,
                'amount'=>$this->amount
            ];
        }
    }
}