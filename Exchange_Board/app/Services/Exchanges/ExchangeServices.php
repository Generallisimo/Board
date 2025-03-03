<?php

namespace App\Services\Exchanges;

use Carbon\Carbon;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Exchange;
use App\Models\Platform;
use Illuminate\Support\Str;
use App\Models\AddMarketDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Components\CheckCurse\CheckCurse;


class ExchangeServices
{

    public function store($client_id, $amount, $currency){
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
                'success'=>true,
                'url'=>config('url.api_local') . "/api/payment/{$exchange_id}/{$wallet->id}"
            ];
        }catch(\Exception $e){
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Error with db transaction : ' . $e->getMessage()
            ];
        }
    }

    public function show($exchange_id, $wallet_id){
        $exchange = Exchange::where('exchange_id',$exchange_id)->first();
        $exchange->amount_users = number_format($exchange->amount_users, 2, '.', '');

        $wallet = AddMarketDetails::where('id', $wallet_id)->first();

        $date = now()->setTimezone('Europe/Podgorica');
        $paymentDate = Carbon::parse($date)->format('m/d/Y, H:i:s A');

        $createdTime = $exchange->created_at;
        $expiresAt = $createdTime->copy()->addMinutes(30);
        $remainingSeconds = max(0, $expiresAt->diffInSeconds(now()));

        return [
            'success'=>true,

            'exchange_id' => $exchange->exchange_id,
            'amount_users' => $exchange->amount_users,

            'method' => $wallet->name_method,
            'wallet_market' => $wallet->details_market_to,
            'currency' => $wallet->currency,
            
            'payment_date' => $paymentDate,
            'remainingTime' => $remainingSeconds,
        ];
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
}