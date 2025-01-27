<?php

namespace App\Services\ApiExchange;

use App\Components\CheckCurse\CheckCurse;
use App\Models\AddMarketDetails;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Exchange;
use App\Models\Market;
use Illuminate\Support\Str;

class ApiExchangesServices
{
    public function store($currency, $amount, $api_key){
        $exchange_id = Str::uuid();

        $market = Market::where('status', 'online')->inRandomOrder()->first();

        if($market === null){
            return [
                'success'=>false
            ];
        }

        $wallet = AddMarketDetails::where('hash_id', $market->hash_id)
            ->where('currency', $currency)
            ->where('online', 'online')
            ->inRandomOrder()
            ->first();

        $client = Client::where('api_key', $api_key)->first();

        if($client === null){
            return [
                'success'=>false
            ];
        }

        $agent = Agent::where('hash_id', $market->agent_id)->first();

        $curse = (new CheckCurse($currency))->curse();

        if($curse['success'] === true){

            $client_percent = $client->percent / 100;
            $market_percent = $market->percent / 100;
            $agent_percent = $agent->percent / 100;
            
            $response = $amount * (1 / $curse['message']);
            
            $amount_exchange = $response * $client_percent;
            $amount_market = $response * $market_percent;
            $amount_agent = $response * $agent_percent;
            $amount_client = $response -($amount_exchange + $amount_agent + $amount_market);

            //add percent if click button client paid

            $exchange = new Exchange([
                'exchange_id' => $exchange_id,
                'method_exchanges'=>'api_key',
                'client_id' => $client->hash_id,
                'market_id' => $market->hash_id,
                'agent_id' => $agent->hash_id,
                'amount' => $response,
                'amount_users'=> $amount,
                'percent_client' => $client_percent* 100,
                'percent_market' => $market_percent * 100,
                'percent_agent' => $agent_percent * 100,
                'method' => $wallet->name_method,
                'currency' => $currency,
                'details_market_payment'=>$wallet->details_market_to,
                'amount_client'=>$amount_exchange,
                'amount_market'=>$amount_market,
                'amount_agent'=>$amount_agent,
                'result_client'=>$amount_client,
            ]);

            $exchange->save();
            
            return [
                'success'=>true,
                'exchange_id'=>$exchange_id,
                'amount_users'=>$amount,
                'currency'=>$currency,
                'method'=>$wallet->name_method,
                'wallet_market'=>$wallet->details_market_to
            ];
        }else{
            return [
                'success'=>false,
                'message'=>'error on server, very soon fixed'
            ];
        }

    }

    public function update($exchange_id){
        $response = Exchange::where('exchange_id', $exchange_id)->first();
        return ['message'=>$response->result];
    }
}