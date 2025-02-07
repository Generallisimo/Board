<?php


namespace App\Components\WithdrawalTRON;

use App\Components\CheckBalance\CheckBalance;
use App\Components\SendToUserTRON\SendTRON;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Platform;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WithdrawalTRON
{

    public $amount;
    public $addressTo;
    public $ownerAddress;
    public $ownerKey;
    public $hash_id;

    // public function __construct($amount, $addressTo, $ownerAddress, $ownerKey, $hash_id)
    public function __construct($amount, $addressTo, $hash_id)
    {
        $this->amount = $amount;
        $this->addressTo = $addressTo;
        // $this->ownerAddress = $ownerAddress;
        // $this->ownerKey = $ownerKey;
        $this->ownerAddress = config('wallet.wallet');
        $this->ownerKey = config('wallet.private_key');
        $this->hash_id = $hash_id;

        // $this->sendTronTrxToUsdt($amount, $addressTo, $ownerAddress, $ownerKey, $hash_id);
    }

    public function store(){

        return $this->sendUsdt(
            $this->amount,
            $this->addressTo,
            $this->ownerAddress,
            $this->ownerKey,
            $this->hash_id
        );

    }

    protected function sendUsdt($amount, $addressTo, $ownerAddress, $ownerKey, $hash_id){
        Log::info("getHashIDWithdrawal: ", [$hash_id]);

        $tronHost = config('tron.host'); 

        $urlSend = $tronHost . '/sendTronUSDT';

        $amountPercent = $amount - 5;
        Log::info("getAmountPercent: ", [$amountPercent]);
        
        $amountInSun = intval($amountPercent * 1000000);
        Log::info("getAmountWithdrawal: ", [$amountInSun]);
        
        try{
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
                ])->post($urlSend, [
                    'addressTo' => $addressTo,
                    'amount' => $amountInSun,
                    'ownerAddress' => $ownerAddress,
                    'privateKey' => $ownerKey,
                ]);
                $responseData = $response->json();
                $transactionHash = $responseData['transactionHash'] ?? 'No transaction hash';
                Log::info("getResponseHashSendTron: ", [$transactionHash]);
                
                $hash_id_find = User::where('hash_id', $hash_id)->first();
                Log::info("getDBHashID: ", [$hash_id_find]);

                if($response->successful()){
                     
                    
                    $getUser = $this->user($hash_id_find);
                    Log::info("getUserForBalance ", [$getUser]);
                    
                    $balanceAfterSuccess = $getUser->decrement('balance', $amount);
                    Log::info("getBalanceAfterSuccess ",  [$balanceAfterSuccess]);

                    $hashPlatform = Platform::where('hash_id', 'platform')->first();
                    $balancePlatform = (new CheckBalance($hashPlatform))->checkBalanceUser();
                    $hashPlatform->update([
                        'balance'=>$balancePlatform['balance']
                    ]);

                    
                    return ['success'=>true];
                }elseif($response->failed()){
                    return[
                        'success' => false,
                        'message' => 'Error withdrawal, send to support'
                    ];
                }
        }catch(Exception $e){
            return [
                'success'=>false,
                'message'=>'Error connection'.$e->getMessage()
            ];
        }
       
    }

    protected function user($hash_id_find){
        if ($hash_id_find->hasRole('admin')) {
            $user = Platform::where('hash_id', $hash_id_find->hash_id)->first();
        } elseif ($hash_id_find->hasRole('agent')) {
            $user = Agent::where('hash_id', $hash_id_find->hash_id)->first();
        } elseif ($hash_id_find->hasRole('client')) {
            $user = Client::where('hash_id', $hash_id_find->hash_id)->first();
        } elseif ($hash_id_find->hasRole('market')) {
            $user = Market::where('hash_id', $hash_id_find->hash_id)->first();
        }
        return $user;
    }
    

    
                    // $test = (new SendTRON(
                    //     '5',
                    //     config('wallet.wallet'),
                    //     $ownerAddress,
                    //     $ownerKey,
                    // ))->send();
                    // Log::info("getWalletConfig ". config('wallet.wallet'));
                    // Log::info("transactionMessage ". $test['message']);

    // protected function user($hash_id_find){

    //     if ($hash_id_find->hasRole('admin')) {
    //         $user = Platform::where('hash_id', $hash_id_find->hash_id)->first();
    //     } elseif ($hash_id_find->hasRole('agent')) {
    //         $user = Agent::where('hash_id', $hash_id_find->hash_id)->first();
    //     } elseif ($hash_id_find->hasRole('client')) {
    //         $user = Client::where('hash_id', $hash_id_find->hash_id)->first();
    //     } elseif ($hash_id_find->hasRole('market')) {
    //         $user = Market::where('hash_id', $hash_id_find->hash_id)->first();
    //     }
    //     new CheckBalance($user);
    // }
}