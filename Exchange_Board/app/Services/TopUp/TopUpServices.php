<?php

namespace App\Services\TopUp;

use App\Components\CheckBalance\CheckBalance;
use App\Components\CheckTransaction\CheckTransaction;
use App\Components\CheckTRXBalance\CheckTRXBalance;
use App\Components\SendToUserTRON\SendTRON;
use App\Jobs\TRX\CheckTRXJob;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TopUpServices
{
    public function index(){
        $hash_id = Auth::user()->hash_id;
        $role = User::where('hash_id', $hash_id)->first();
       
        if($role->hasRole('admin')){
            $user = Platform::where('hash_id', $hash_id)->first();
            return ['user'=>$user];
        }elseif($role->hasRole('market')){
            $user = Market::where('hash_id', $hash_id)->first();
            return ['user'=>$user];
        }
    }

   public function update($wallet, $hash_id){

    $result = (new CheckTransaction($wallet))->check();
    $role = User::where('hash_id', $hash_id)->first();
    $user = $this->user($role, $hash_id);
    
    $balance = (new CheckBalance($user))->checkBalanceUser();
    Log::info('getCheckBalance', [$balance]);

    Log::info('getBeforeUpdate', [$user->balance]);
    $balanceDB = $user->increment('balance', $balance['balance']);
    Log::info('getAfterUpdate', [$user->balance]);
    Log::info('getUserBalance', [$balanceDB]);
    
    $walletOwner = config('wallet.wallet');
    
    $sendMainWallet = (new SendTRON($balance['balance'], $walletOwner, $user->details_from, $user->private_key ))->send();
    Log::info('getResultWallet', [$sendMainWallet]);
    
    if($balance['success']){
        // $trx = CheckTRXJob::dispatch($wallet);
        $trx = (new CheckTRXBalance($wallet))->update();
        Log::info("getResponseTRX: " . json_encode(['result' => $trx]));
        if($trx['success'] === false){
            $balanceMinusDB = $user->decrement('balance', $balance['balance']);
            Log::info('getUserBalanceMinus', [$balanceMinusDB]);
        }
    }

    return ['result'=> $result];
    
    }

   protected function user($role, $hash_id){
        if($role->hasRole('admin')){
            return Platform::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('market')){
            return Market::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('agent')){
            return Agent::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('client')){
            return Client::where('hash_id', $hash_id)->first();
        }
    }
}