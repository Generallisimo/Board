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

    public function __construct($amount, $addressTo, $ownerAddress, $ownerKey, $hash_id)
    {
        $this->amount = $amount;
        $this->addressTo = $addressTo;
        $this->ownerAddress = $ownerAddress;
        $this->ownerKey = $ownerKey;
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
        $tronHost = config('tron.host'); 

        $urlSend = $tronHost . '/sendTronUSDT';

        $amountInSun = intval($amount * 1000000);
        
        try{
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
                ])->post($urlSend, [
                    'addressTo' => $addressTo,
                    'amount' => $amountInSun,
                    'ownerAddress' => $ownerAddress,
                    'privateKey' => $ownerKey,
                ]);
    
                
                $hash_id_find = User::where('hash_id', $hash_id)->first();
    
                if($response->successful()){
                     
                    $test = (new SendTRON(
                        '5',
                        config('wallet.wallet'),
                        $ownerAddress,
                        $ownerKey,
                    ))->send();

                    Log::info("Кошелек вывода ". config('wallet.wallet'));
                    Log::info("Кошелек пополнения ".  $ownerAddress);
                    Log::info("Сообщение об переводи комиссии ". $test['message']);

                    $this->user($hash_id_find);
                    return ['success'=>true];
                }elseif($response->failed()){
                    return[
                        'success' => false,
                        'message' => $response->json()['message'] ?? 'Ошибка вывода, обратитесь в тех поддержку'
                    ];
                }
        }catch(Exception $e){
            return [
                'success'=>false,
                'message'=>'Ошибка соеденения'.$e->getMessage()
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
        new CheckBalance($user);
    }
}