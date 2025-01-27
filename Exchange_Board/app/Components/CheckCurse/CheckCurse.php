<?php

namespace App\Components\CheckCurse;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckCurse{

    public $currency;

    public function __construct($currency)
    {
        $this->currency = $currency;
    }
    
    public function curse(){

        try{
            
            $send_currency = 'USDT';
            $get_currency = strtoupper($this->currency);
            $curse = Http::get('https://api.binance.com/api/v3/ticker/price', [
                'symbol'=> $send_currency . $get_currency
            ]);
            
            if($curse->successful()){
               $data = $curse->json();
               return [
                'success'=> true,
                'message'=>$data['price']
               ];
            }else{
                return [
                    'success'=> false,
                    'message'=>'Ошибка в конвертации валюты'
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