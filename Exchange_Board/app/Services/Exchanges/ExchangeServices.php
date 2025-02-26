<?php

namespace App\Services\Exchanges;

use Carbon\Carbon;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Exchange;
use App\Models\Platform;
use Illuminate\Support\Str;
use App\Jobs\UpdateExchangeJob;
use App\Models\AddMarketDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Components\CheckTXID\CheckTXID;
use App\Components\CheckCurse\CheckCurse;
use App\Components\SendToUserTRON\SendTRON;


class ExchangeServices
{

    public function show($client_id, $amount, $currency){
        $currency = strtoupper($currency); // Приводим к верхнему регистру

        if($amount <= 0){
            return [
                'success'=>false,
                'message'=>'error amount'
            ];
        }

        $exchange_id = Str::uuid();

        $platform = Platform::where('hash_id','platform')->first();

        $platformCommission = $platform->status_commission === 'online'; 
        $amountBefore = $amount >= 150;
        $amountAfter = $amount <= 1200;
        $rangeAmount = in_array($amount % 100, range(1,5));
        $currencyUAH = $currency === 'UAH';

        if($platformCommission && $amountBefore && $amountAfter && $rangeAmount && $currencyUAH){
            $randomCommission = rand(1,29);
            $amount += $randomCommission;
        }

        $curse = (new CheckCurse($currency))->curse();
        $amountUSDT = $amount * (1 / $curse['message']);

        DB::beginTransaction();


        try{
            $market = Market::where("status", 'online')
                ->where('balance', '>=', $amountUSDT)
                ->inRandomOrder()
                ->first();

            if($market === null){
                DB::rollBack();
                return [
                    'success' => false, 
                    'message' => 'Not found market with balance'
                ];
            }

            $market->balance -= $amountUSDT;
            $market->balance_hold += $amountUSDT;
            $market->save();

            $wallet = AddMarketDetails::where('online', 'online')
                ->where('currency', $currency)
                ->where('hash_id', $market->hash_id)
                ->inRandomOrder()
                ->first();
            
            if($wallet === null){
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'Not found market cards online'
                ];
            }

            $client = Client::where('hash_id', $client_id)->first();

            $agent = Agent::where('hash_id', $market->agent_id)->first();
            
            $client_percent = $client->percent / 100;
            $market_percent = $market->percent / 100;
            $agent_percent = $agent->percent / 100;        
            $platform_percent = $client_percent - ($market_percent + $agent_percent);
            
    
            $amount_exchange = $amountUSDT * $platform_percent;
            $amount_market = $amountUSDT * $market_percent;
            $amount_agent = $amountUSDT * $agent_percent;
            $amount_client = $amountUSDT - ($amount_exchange + $amount_agent + $amount_market);

            $date = now()->setTimezone('Europe/Podgorica');
            $paymentDate = Carbon::parse($date)->format('m/d/Y, H:i:s A');
            
            
            $createdTime = Carbon::parse();
            $expiresAt = $createdTime->addMinutes(30);
            $remainingSeconds = max(0, $expiresAt->diffInSeconds(now()));

            $exchange = new Exchange([
                'exchange_id' => $exchange_id,
                'method_exchanges' => 'api_key',
                'client_id' => $client->hash_id,
                'market_id' => $market->hash_id,
                'market_api_key' => $market->api_key,
                'agent_id' => $agent->hash_id,
                'amount' => $amountUSDT,
                'amount_users' => $amount,
                'percent_client' => $client_percent * 100,
                'percent_market' => $market_percent * 100,
                'percent_agent' => $agent_percent * 100,
                'method' => $wallet->name_method,
                'currency' => $currency,
                'details_market_payment' => $wallet->details_market_to,
                'amount_client' => $amount_exchange,
                'amount_market' => $amount_market,
                'amount_agent' => $amount_agent,
                'result_client' => $amount_client,
            ]);
    
            $exchange->save();
    
            DB::commit();

            return [
                'success' => true,
                'exchange_id' => $exchange_id,
                'amount_users' => $amount,
                'method' => $wallet->name_method,
                'wallet_market' => $wallet->details_market_to,
                'payment_date' => $paymentDate,
                'remainingTime' => $remainingSeconds,
                'currency' => $currency
            ];
        }catch(\Exception $e){
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Error with db transaction : ' . $e->getMessage()
            ];
        }
    }
        
    public function update($exchange){
        $date = now()->setTimezone('Europe/Podgorica');
        $paymentDate = Carbon::parse($date)->format('m/d/Y, H:i:s A');

        $response = Exchange::where('exchange_id', $exchange)->first();

        $data = $response->toArray();
        $data['amount_users'] = number_format($response->amount_users, 2, '.', ''); // Оставляем 2 знака после запятой
        $data['payment_date'] = $paymentDate; 
        
        return $data;
    }

    public function index($exchange){
        
        $result = Exchange::where('exchange_id', $exchange)->first();
        Log::info("getAPIresultExchange: ", [$result]);
        return ['status' => $result->result];
    }




    // public function index($client_id, $amount, $currency, $data){
    //     $exchange_id = Str::uuid();
        
    //     if($amount <= 0){
    //         return [
    //             'success'=>false,
    //             'message'=>'ошибка суммы'
    //         ];
    //     }
        
    //     $curse = (new CheckCurse($currency))->curse();
    //     $response = $amount * (1 / $curse['message']);

    //     $market = Market::where('status', 'online')
    //     ->where('balance', '>=', $response)
    //     ->inRandomOrder()
    //     ->first();
        
    //     if ($market === null) {
    //         return [
    //             'success' => false,
    //             'message' => 'Нет доступного менялы с достаточным балансом'
    //         ];
    //     }

    //     $market->balance -= $response;
    //     $market->balance_hold += $response;
    //     $market->save();

    //     $market_id=$market->hash_id;
         
    //     //add status online for view method payments
    //     $market_method = AddMarketDetails::where('hash_id', $market->hash_id)->where('currency', $currency)->where('online', 'online')->get();
    //     $unique_method = $market_method->unique('name_method');

    //     return [
    //         'success'=>true,
    //         'client_id'=>$client_id,
    //         'market_id'=>$market_id,
    //         'market_api_key' => $market->api_key,
    //         'amount'=>$amount,
    //         'exchange_id'=>$exchange_id,
    //         'currency'=>$currency,
    //         'unique_method'=>$unique_method,
    //         'callback'=>$data
    //     ];
        
    
    // }

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
            $platform_percent = $client_percent - ($market_percent + $agent_percent);

            $response = $amount * (1 / $curse['message']);
            
            $amount_exchange = $response * $platform_percent;
            $amount_market = $response * $market_percent;
            $amount_agent = $response * $agent_percent;
            $amount_client = $response -($amount_exchange + $amount_agent + $amount_market);

            //add percent if click button client paid
    
            return [
                'success'=>true,
                'client'=>$client_id,
                'market'=>$market_id,
                'market_api_key' => $market->api_key,
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
        // dd($data);

        $exchange = new Exchange([
            'exchange_id' => $exchange_id,
            'method_exchanges'=>'api_link',
            'client_id' => $data['client_id'],
            'market_id' => $data['market_id'],
            'market_api_key' => $data['market_api_key'],
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


}