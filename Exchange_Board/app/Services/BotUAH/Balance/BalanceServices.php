<?php

namespace App\Services\BotUAH\Balance;

use App\Models\User;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Platform;
use App\Jobs\TRX\CheckTRXJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Components\CheckBalance\CheckBalance;
use App\Components\WithdrawalTRON\WithdrawalTRON;
use App\Components\CheckTransaction\CheckTransaction;
use App\Models\AgentUAH;
use App\Models\ClientUAH;
use App\Models\MarketUAH;

class BalanceServices
{

    public function update($hash_id, $you_send, $you_send_details) {
        // if (!Auth::check()) {
        //     Log::error('Пользователь не аутентифицирован');
        //     return false;
        // }
    
        // $hash_id = Auth::user()->hash_id;
        $role = User::where('hash_id', $hash_id)->first();
    
        if (!$role) {
            Log::error('Роль пользователя с hash_id не найдена', ['hash_id' => $hash_id]);
            return false;
        }
    
        $userID = $this->user($role, $hash_id);
    
        if (!$userID) {
            Log::error('Пользователь с hash_id не найден', ['hash_id' => $hash_id]);
            return false;
        }
    
        CheckTRXJob::dispatch($userID->details_from);
    
        $initialBalance = (new CheckBalance($userID))->checkBalanceUser();
    
        $result = (new WithdrawalTRON(
            $you_send,
            $you_send_details,
            $userID->details_from,
            $userID->private_key,
            $hash_id
        ))->store();
    
        $newBalance  = (new CheckBalance($userID))->checkBalanceUser();
    
        if ($initialBalance !== $newBalance) {
            return true;
        } else {
            Log::info('Transaction failed');
            return $result['message'] ?? 'Транзакция не прошла успешно';
        }
    }
    

    protected function user($role, $hash_id){
        if($role->hasRole('admin')){
            return Platform::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('client')){
            return ClientUAH::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('market')){
            return MarketUAH::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('agent')){
            return AgentUAH::where('hash_id', $hash_id)->first();
        }
    }

    public function store($wallet, $hash_id){

        $result = (new CheckTransaction($wallet))->check();
        $role = User::where('hash_id', $hash_id)->first();
        $user = $this->userSend($role, $hash_id);
    
        $balance = (new CheckBalance($user))->checkBalanceUser();
            Log::info('Check success, balance: ' . $balance['success']);
            if($balance['success']){
                $trx = CheckTRXJob::dispatch($wallet);
                Log::info("TRX response: " . json_encode(['result' => $trx]));
                return ['result'=> $result];
            }
        }
    
       protected function userSend($role, $hash_id){
            if($role->hasRole('admin')){
                return AgentUAH::where('hash_id', $hash_id)->first();
            }elseif($role->hasRole('market')){
                return MarketUAH::where('hash_id', $hash_id)->first();
            }elseif($role->hasRole('market')){
                return ClientUAH::where('hash_id', $hash_id)->first();
            }elseif($role->hasRole('market')){
                return Platform::where('hash_id', $hash_id)->first();
            }
        }
}