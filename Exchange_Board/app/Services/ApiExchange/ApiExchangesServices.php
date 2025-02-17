<?php

namespace App\Services\ApiExchange;

use App\Components\CheckCurse\CheckCurse;
use App\Models\AddMarketDetails;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Exchange;
use App\Models\Market;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class ApiExchangesServices
{
    public function store($currency, $amount, $api_key){

    if($amount <= 0){
        return [
            'success'=>false,
            'message'=>'ошибка суммы'
        ];
    }
    
    $exchange_id = Str::uuid();

    $curse = (new CheckCurse($currency))->curse();
    $response = $amount * (1 / $curse['message']);

    DB::beginTransaction();

    try {
        // Поиск менялы с достаточным балансом
        $market = Market::where('status', 'online')
            ->where('balance', '>=', $response)
            ->inRandomOrder()
            ->lockForUpdate() // Блокируем запись для изменений другими запросами
            ->first();

        if ($market === null) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Нет доступного менялы с достаточным балансом'
            ];
        }

        // Уменьшаем баланс и увеличиваем balance_hold
        $market->balance -= $response;
        $market->balance_hold += $response;
        $market->save();

        // Проверяем клиента
        $client = Client::where('api_key', $api_key)->first();
        if ($client === null) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Клиент с таким API ключом не найден'
            ];
        }

        $wallet = AddMarketDetails::where('hash_id', $market->hash_id)
            ->where('currency', $currency)
            ->where('online', 'online')
            ->inRandomOrder()
            ->first();

        $agent = Agent::where('hash_id', $market->agent_id)->first();

        if ($curse['success'] !== true) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Ошибка в получении курса обмена'
            ];
        }

        // Вычисление процентов
        
        $client_percent = $client->percent / 100;
        $market_percent = $market->percent / 100;
        $agent_percent = $agent->percent / 100;
        
        // $platformPercent = ($market_percent + $agent_percent) - $client_percent;
        // dd($platformPercent);
        // $platformPercent = $client->percent;

        $amount_exchange = $response * $client_percent;
        $amount_market = $response * $market_percent;
        $amount_agent = $response * $agent_percent;
        $amount_client = $response - ($amount_exchange + $amount_agent + $amount_market);

        // Сохраняем обмен
        $exchange = new Exchange([
            'exchange_id' => $exchange_id,
            'method_exchanges' => 'api_key',
            'client_id' => $client->hash_id,
            'market_id' => $market->hash_id,
            'market_id_api_key' => $market->api_key,
            'agent_id' => $agent->hash_id,
            'amount' => $response,
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
            'currency' => $currency,
            'method' => $wallet->name_method,
            'wallet_market' => $wallet->details_market_to
        ];
    } catch (\Exception $e) {
        DB::rollBack();

        return [
            'success' => false,
            'message' => 'Произошла ошибка: ' . $e->getMessage()
        ];
    }
}

    public function update($exchange_id){
        $response = Exchange::where('exchange_id', $exchange_id)->first();
        return [
            'result'=>$response->result,
            'message'=>$response->message,
        ];
    }
}