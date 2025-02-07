<?php

namespace App\Components\CheckTRXBalance;

use App\Components\SendToUserTRX\SendTRX;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckTRXBalance
{
    public $ownerAddress;

    public function __construct($ownerAddress)
    {
        $this->ownerAddress = $ownerAddress;
    }

    public function update(){
        $tronHost = config('tron.host'); 

        Log::info('getWalletForTRX: ', [$this->ownerAddress]);
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
                        'send'=>'Sent 200 TRX'
                    ];
                }else{
                    return [
                        'success'=>false,
                        'message'=>'Error transaction 100 TRX'
                    ];
                }
            }else{
                return [
                    'success'=>true,
                    'message'=>$result->json(),
                    'send'=>'More 100 TRX'
                ];
            }

        }catch(Exception $e){
            return [
                'success'=>false,
                'message'=>"Error connection: " . $e->getMessage()
            ];
        }
    }
}