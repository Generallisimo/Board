<?php

namespace App\Components\CheckBalance;

use App\Models\Agent;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckBalance{

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
        $this->checkBalanceUser();

    }
    
    public function checkBalanceUser(){

        $tronHost = config('tron.host'); 
        try{
            // $currentBalance = $this->user->balance;

            $checkBalance = Http::get($tronHost . '/check_balance', [
                'ownerAddress'=>$this->user->details_from,
            ]);
            $responseBalance = $checkBalance->json();
            $amountUpdate = $responseBalance['balance'];
            
            // if($currentBalance !== $amountUpdate){
            //     $this->user->balance = $amountUpdate;
            //     $this->user->save(); 
            // }
            // add validate error
            return [
                'success'=> true,
                'balance'=> $amountUpdate
            ];
           
        }catch(Exception $e){
            return [
                'success'=>false,
                'message'=>'Ошибка соеденения'.$e->getMessage()
            ];
        }
    }
}