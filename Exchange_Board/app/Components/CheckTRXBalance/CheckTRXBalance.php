<?php

namespace App\Components\CheckTRXBalance;

use App\Components\SendToUserTRX\SendTRX;
use Exception;
use Illuminate\Support\Facades\Http;

class CheckTRXBalance
{
    public $ownerAddress;

    public function __construct($ownerAddress)
    {
        $this->ownerAddress = $ownerAddress;
    }

    public function update(){
        $tronHost = config('tron.host'); 

        try{

            $result = Http::get($tronHost . '/checkTRX', [
                'ownerAddress'=>$this->ownerAddress
            ]);
            $data = $result->json();
            if( $data['result']['balance'] < 100){
                $response = (new SendTRX($this->ownerAddress, '200'))->sendTRX();
                if($response === true){
                    return [
                        'success'=>true,
                        'message'=>$result->json(),
                        'send'=>'отправлено 200 TRX'
                    ];
                }else{
                    return [
                        'success'=>false,
                        'message'=>'Ошибка в перевод 100 TRX'
                    ];
                }
            }else{
                return [
                    'success'=>true,
                    'message'=>$result->json(),
                    'send'=>'Больше 100 TRX'
                ];
            }

        }catch(Exception $e){
            return [
                'success'=>false,
                'message'=>"Ошибка соединения: " . $e->getMessage()
            ];
        }
    }
}