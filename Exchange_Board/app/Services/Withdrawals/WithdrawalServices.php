<?php

namespace App\Services\Withdrawals;

use App\Models\User;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Platform;
use App\Jobs\TRX\CheckTRXJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Components\SendToUserTRON\SendTRON;
use App\Components\CheckBalance\CheckBalance;
use App\Components\WithdrawalTRON\WithdrawalTRON;
use App\Components\CheckTRXBalance\CheckTRXBalance;

class WithdrawalServices
{
    public function index(){
        $hash_id = Auth::user()->hash_id;
        $role = User::where('hash_id', $hash_id)->first();
        $user = $this->user($role, $hash_id);
        return ['user'=>$user];
    }

    public function update(array $data_request){
        Log::info("getAmountFromUser: ", [$data_request['you_send']]);
        $hash_id = Auth::user()->hash_id;
        $role = User::where('hash_id', $hash_id)->first();
        
        $userBefore = $this->user($role, $hash_id);

        $wallet = config('wallet.wallet');
        $trx = (new CheckTRXBalance($wallet))->update();
        Log::info("getResponseTRX: " . json_encode(['result' => $trx]));
        
        $initialBalance = $userBefore->balance;
        Log::info("getBeforeWithdrawalBalanceUser: ", [$initialBalance]);

        $middleware = $data_request['you_send'] + 5;
        if($initialBalance < $middleware){
            Log::info('Mooney don`t have');
            return 'Недостаточно средств ';
        }
        $result = (new WithdrawalTRON(
            $data_request['you_send'],
            $data_request['you_send_details'],
            $data_request['hash_id']
        ))->store();

        $userAfter = $this->user($role, $hash_id);
        $newBalance  = $userAfter->balance;
        Log::info("getAfterWithdrawalBalanceUser: ", [$newBalance]);

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