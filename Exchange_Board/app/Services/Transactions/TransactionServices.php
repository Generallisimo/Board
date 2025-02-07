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
        
        if($resultSuccess === 'to_success'){
            
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

            $platform = Platform::where('hash_id', $exchange_id->agent_id)->first();
            Log::info("getPlatformUser: ", [$platform]);
            
            if($platform){
                Log::info("getPlatformID: ", [$exchange_id->agent_id]);
                Platform::where('hash_id', $exchange_id->agent_id)->increment('balance', $exchange_id->amount_client);
                Log::info("sendAmountPlatform");
            }else{
                Agent::where('hash_id', $exchange_id->agent_id)->increment('balance', $exchange_id->amount_agent);
                Log::info("sendAmountAgent");
            }
            
            Market::where('hash_id', $exchange_id->market_id)->increment('balance', $exchange_id->amount_market);
            Market::where('hash_id', $exchange_id->market_id)->decrement('balance_hold', $exchange_id->amount);
            Client::where('hash_id', $exchange_id->client_id)->increment('balance', $exchange_id->result_client);
        }

        return $result ? true : "Ошибка обратитесь в поддержку"; 

        // $market = Market::where('hash_id', $exchange_id->market_id)->first();
        // CheckTRXJob::dispatch($market->details_from);

        // $callback = $exchange_id->callback;
        
        // if($status === 'fraud'){    
        //     $client = Client::where('hash_id', $exchange_id->client_id)->first();
        //     $currentFraudValue = $client->fraud;
        //     $client->update([
        //         'fraud' => $currentFraudValue + 1
        //     ]);

        //     CallbackJob::dispatch($callback, $status);
        // }elseif($status === 'error'){
        //     CallbackJob::dispatch($callback, $status);
        // }elseif($status === 'archive'){
        //     CallbackJob::dispatch($callback, $status);
        // }elseif($status === 'to_success'){
        //     CallbackJob::dispatch($callback, 'success');
        // }elseif($status === 'fraud'){
        //     CallbackJob::dispatch($callback, $status);
        // }
        
        // UpdateJob::dispatch($exchange);

    }
}