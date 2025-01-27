<?php

namespace App\Services\Exchanges;

use App\Components\CheckCurse\CheckCurse;
use App\Components\CheckTXID\CheckTXID;
use App\Components\SendToUserTRON\SendTRON;
use App\Jobs\UpdateExchangeJob;
use App\Models\AddMarketDetails;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Exchange;
use App\Models\Market;
use App\Models\Platform;
use Illuminate\Support\Str;


class ExchangeServices
{
    public function index($client_id, $amount, $currency, array $data){
        $exchange_id = Str::uuid();

        $market = Market::where('status', 'online')->inRandomOrder()->first();
        // dd($market);
        if($market === null){
            return [
                'success'=>false
            ];
        }

        $market_id=$market->hash_id;
         
        //add status online for view method payments
        $market_method = AddMarketDetails::where('hash_id', $market->hash_id)->where('currency', $currency)->where('online', 'online')->get();
        $unique_method = $market_method->unique('name_method');

        return [
            'success'=>true,
            'client_id'=>$client_id,
            'market_id'=>$market_id,
            'amount'=>$amount,
            'exchange_id'=>$exchange_id,
            'currency'=>$currency,
            'unique_method'=>$unique_method,
            'callback'=>$data['callback']
        ];
        
    
    }

    public function create($client_id,$amount, $currency, $market_id, $exchange_id, array $data){

        // dd($data);
        $client = Client::where('hash_id', $client_id)->first();

        $market = Market::where('hash_id', $market_id)->first();

        $wallet = AddMarketDetails::where('name_method', $data['method'])
            ->where('hash_id', $market->hash_id)
            ->where('online', 'online')
            ->inRandomOrder()
            ->first();

        if($wallet === null){
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
    
            return [
                'success'=>true,
                'client'=>$client_id,
                'market'=>$market_id,
                'agent'=>$agent->hash_id,
                'amount_users'=>$amount,
                'amount'=>$response,
                'exchange_id'=>$exchange_id,
                'currency'=>$currency,
                'method'=>$data['method'],
                'percent_client'=>$client_percent,
                'percent_market'=>$market_percent,
                'percent_agent'=>$agent_percent,
                'amount_exchange'=>$amount_exchange,
                'amount_market'=>$amount_market,
                'amount_agent'=>$amount_agent,
                'result_client'=>$amount_client,
                'wallet_market'=>$wallet,
                'callback'=>$data['callback']
            ];
        }else{
            return [
                'success'=>false,
                'message'=>$curse['message']
            ];
        }
    }

    public function store($exchange_id, array $data){

        $exchange = Exchange::where('exchange_id', $exchange_id)->first();

        if ($exchange) {
            return true;
        }

        $exchange = new Exchange([
            'exchange_id' => $exchange_id,
            'method_exchanges'=>'api_link',
            'client_id' => $data['client_id'],
            'market_id' => $data['market_id'],
            'agent_id' => $data['agent_id'],
            'amount' => $data['amount'],
            'amount_users'=> $data['amount_users'],
            'percent_client' => $data['percent_client'] * 100,
            'percent_market' => $data['percent_market'] * 100,
            'percent_agent' => $data['percent_agent'] * 100,
            'method' => $data['method'],
            'currency' => $data['currency'],
            'details_market_payment'=>$data['details_market_payment'],
            'amount_client'=>$data['amount_client'],
            'amount_market'=>$data['amount_market'],
            'amount_agent'=>$data['amount_agent'],
            'result_client'=>$data['result_client'],
            'photo'=>$data['photo'],
            'callback'=>$data['callback']
        ]);

        return $exchange->save() ? true : false;
    }

    public function update($exchange){
        $response = Exchange::where('exchange_id', $exchange)->first();

        return ['message'=>$response->result];
    }
}