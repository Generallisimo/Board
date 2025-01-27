<?php

namespace App\Services\Withdrawals;

use App\Components\CheckBalance\CheckBalance;
use App\Components\SendToUserTRON\SendTRON;
use App\Components\WithdrawalTRON\WithdrawalTRON;
use App\Jobs\TRX\CheckTRXJob;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WithdrawalServices
{
    public function index(){
        $hash_id = Auth::user()->hash_id;
        $role = User::where('hash_id', $hash_id)->first();
        $user = $this->user($role, $hash_id);
        return ['user'=>$user];
    }

    public function update(array $data_request){

        $hash_id = Auth::user()->hash_id;
        $role = User::where('hash_id', $hash_id)->first();
        
        $userID = $this->user($role, $hash_id);

        CheckTRXJob::dispatch($userID->details_from);
        
        $initialBalance = (new CheckBalance($userID))->checkBalanceUser();

        $result = (new WithdrawalTRON(
            $data_request['you_send'],
            $data_request['you_send_details'],
            $userID->details_from,
            $userID->private_key,
            $data_request['hash_id']
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
            return Client::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('market')){
            return Market::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('agent')){
            return Agent::where('hash_id', $hash_id)->first();
        }
    }
}