<?php

namespace App\Services\Transactions;

use App\Models\Client;
use App\Models\Market;
use App\Models\Exchange;
use App\Jobs\TRX\CheckTRXJob;
use App\Jobs\Exchange\AgentJob;
use App\Jobs\UpdateExchangeJob;
use App\Jobs\Exchange\ClientJob;
use App\Jobs\Exchange\UpdateJob;
use App\Jobs\Exchange\PlatformJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Jobs\Transaction\CallbackJob;
use App\Models\Agent;
use App\Models\Platform;
use App\Models\ProfitUser;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionServices
{

    public function index(){
        
        $user = Auth::user();

        if ($user->hasRole('admin') || $user->hasRole('support')) {
            $exchanges = Exchange::where('result', 'await')->orderBy('created_at', 'desc')->get();
            $exchangesSuccess = Exchange::where('result', 'success')->orderBy('created_at', 'desc')->get();
            $exchangesArchive = Exchange::where('result', 'archive')->orderBy('created_at', 'desc')->get();
            $exchangesDispute = Exchange::where('result', 'dispute')->orderBy('created_at', 'desc')->get();
            $exchangesError = Exchange::where('result', 'error')->orderBy('created_at', 'desc')->get();
            $exchangesFraud = Exchange::where('result', 'fraud')->orderBy('created_at', 'desc')->get();
            $exchangesToSuccess = Exchange::where('result', 'to_success')->orderBy('created_at', 'desc')->get();

        }elseif($user->hasRole('market')){
            $exchanges = Exchange::where('market_id', $user->hash_id)->where('result', 'await')->orderBy('created_at', 'desc')->get();
            $exchangesSuccess = Exchange::where('market_id', $user->hash_id)->where('result', 'success')->orderBy('created_at', 'desc')->get();
            $exchangesArchive = Exchange::where('market_id', $user->hash_id)->where('result', 'archive')->orderBy('created_at', 'desc')->get();
            $exchangesDispute = Exchange::where('market_id', $user->hash_id)->where('result', 'dispute')->orderBy('created_at', 'desc')->get();
            $exchangesError = Exchange::where('market_id', $user->hash_id)->where('result', 'error')->orderBy('created_at', 'desc')->get();
            $exchangesFraud = Exchange::where('market_id', $user->hash_id)->where('result', 'fraud')->orderBy('created_at', 'desc')->get();
            $exchangesToSuccess = Exchange::where('result', 'to_success')->orderBy('created_at', 'desc')->get();

            // dd($exchangesSuccess);
        }elseif($user->hasRole('agent')){
            $exchanges = Exchange::where('agent_id', $user->hash_id)->where('result', 'await')->orderBy('created_at', 'desc')->get();
            $exchangesSuccess = Exchange::where('agent_id', $user->hash_id)->where('result', 'success')->orderBy('created_at', 'desc')->get();
            $exchangesArchive = Exchange::where('agent_id', $user->hash_id)->where('result', 'archive')->orderBy('created_at', 'desc')->get();
            $exchangesDispute = Exchange::where('agent_id', $user->hash_id)->where('result', 'dispute')->orderBy('created_at', 'desc')->get();
            $exchangesError = Exchange::where('agent_id', $user->hash_id)->where('result', 'error')->orderBy('created_at', 'desc')->get();
            $exchangesFraud = Exchange::where('agent_id', $user->hash_id)->where('result', 'fraud')->orderBy('created_at', 'desc')->get();
            $exchangesToSuccess = Exchange::where('result', 'to_success')->orderBy('created_at', 'desc')->get();

        }
        return [
            'exchanges'=>$exchanges,
            'exchangesSuccess'=>$exchangesSuccess,
            'exchangesArchive'=>$exchangesArchive, 
            'exchangesDispute'=>$exchangesDispute,
            'exchangesError'=>$exchangesError,
            'exchangesFraud'=>$exchangesFraud,
            'exchangesToSuccess'=>$exchangesToSuccess
        ];
    }

    public function update($exchange, $status, $message){
        $result = Exchange::where('exchange_id', $exchange)->update([
            'result'=>$status,
            'message'=>$message
        ]);
        
        $exchange_id = Exchange::where('exchange_id', $exchange)->first();
        
        $resultSuccess = $exchange_id->result;
        
        if($resultSuccess === 'archive' || $resultSuccess === 'fraud'){
            $marketCash = Market::where('hash_id', $exchange_id->market_id)->first();
            $amountAll = $exchange_id->amount;
            // $marketBalanceHold = $marketCash->balance_hold;
            $marketCash->increment('balance', $amountAll);
            $marketCash->decrement('balance_hold', $amountAll);
        }

        if($resultSuccess === 'success'){
            
            $marketCash = Market::where('hash_id', $exchange_id->market_id)->first();
            $amountAll = $exchange_id->amount;
            $checkBalance = $marketCash->balance_hold < $amountAll; 
            Log::info("getMarketBalance: ", [$checkBalance]);
            
            if($checkBalance){
                Exchange::where('exchange_id', $exchange)->update([
                    'result'=>'error',
                    'message'=>'ошибка перевода'
                ]);
                return false;
            }
            
            // заработок куратора / возможно платформе в роли куратора
            Agent::where('hash_id', $exchange_id->agent_id)->increment('balance', $exchange_id->amount_agent);
            // заработок менялы
            Market::where('hash_id', $exchange_id->market_id)->increment('balance', $exchange_id->amount_market);
            // снимаем деньги с холда
            Market::where('hash_id', $exchange_id->market_id)->decrement('balance_hold', $exchange_id->amount);
            // заработок клиента
            Client::where('hash_id', $exchange_id->client_id)->increment('balance', $exchange_id->result_client);
            // заработок платформу от процента на клиент
            Agent::where('hash_id', 'platform')->increment('balance', $exchange_id->amount_client);

            // деньги менялы
            $this->storeTransaction($exchange, $exchange_id->market_id, 'меняла', $exchange_id->amount, 'отправлено');
            $this->storeTransaction($exchange, $exchange_id->market_id, 'меняла', $exchange_id->amount_market, 'доход');
            // деньги клиента
            $this->storeTransaction($exchange, $exchange_id->client_id, 'клиент', $exchange_id->result_client, 'доход');
            // деньги куратора
            $this->storeTransaction($exchange, $exchange_id->agent_id, 'куратор', $exchange_id->amount_agent, 'доход');
            // деньги платформы
            $this->storeTransaction($exchange, 'platform', 'платформа', $exchange_id->amount_client, 'доход');
        
            //доход клиента
            $this->storeProfit($exchange_id->client_id, $exchange_id->result_client);
            //доход менялы
            $this->storeProfit($exchange_id->market_id, $exchange_id->amount_market);
            //доход платформы
            $this->storeProfit('platform', $exchange_id->amount_client);
            //доход куратора
            $this->storeProfit($exchange_id->agent_id, $exchange_id->amount_agent);
        }

        return $result ? true : "Ошибка обратитесь в поддержку"; 

    }

    protected function storeTransaction($exchange_id, $user_id, $user_role, $amount, $status ){
        Transaction::create([
            'exchange_id'=>$exchange_id,
            'user_id'=>$user_id,
            'user_role'=>$user_role,
            'amount'=>$amount,
            'status'=>$status
        ]);
    }

    protected function storeProfit($hash_id, $amount_profit){
        ProfitUser::create([
            'hash_id'=>$hash_id,
            'amount_profit'=>$amount_profit,
            'changed_at'=>Carbon::now(),
        ]);
    }
}





            // $platform = Platform::where('hash_id', $exchange_id->agent_id)->first();
            // Log::info("getPlatformUser: ", [$platform]);
            
            // if($platform){
            //     Log::info("getPlatformID: ", [$exchange_id->agent_id]);
                
            //     // заработок платформы в роли куратора
            //     Platform::where('hash_id', $exchange_id->agent_id)->increment('balance', $exchange_id->amount_client);
            //     Log::info("sendAmountPlatform");
            // }else{
                
            //     Log::info("sendAmountAgent");
            // }