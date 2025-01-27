<?php

namespace App\Services\BotUAH\Binance\Exchange;

use App\Models\ClientUAH;
use App\Models\MarketUAH;
use App\Models\ExchangeUAH;
use App\Jobs\TRX\CheckTRXJob;
use App\Jobs\Transaction\CallbackJob;
use App\Jobs\BotUAH\Binance\Exchange\UpdateJob;

class ExchangeServices
{
    public function indexMarket($market_id, $status){
        $exchanges = ExchangeUAH::where('market_id', $market_id)->where('result', $status)->get();

        if($exchanges){
            return ['success'=>$exchanges];
        }else{
            return ['error'=>'ошибка при получение данных'];
        }
    }
    
    public function show($exchange_id){
        $exchanges = ExchangeUAH::where('id', $exchange_id)->first();

        if($exchanges){
            return ['success'=>$exchanges];
        }else{
            return ['error'=>'ошибка при получение данных'];
        }
    }

    public function update($exchange_id, $status)
{
    // Обновляем статус сделки
    $exchanges = ExchangeUAH::where('id', $exchange_id)->update([
        'result' => $status,
    ]);

    // Получаем объект ExchangeUAH
    $exchange = ExchangeUAH::where('id', $exchange_id)->first();

    if (!$exchange) {
        return ['error' => 'Сделка не найдена'];
    }

    // Получаем объект MarketUAH
    $market = MarketUAH::where('hash_id', $exchange->market_id)->first();

    if ($market) {
        CheckTRXJob::dispatch($market->details_from);
    }

    // Если статус fraud, обновляем информацию о клиенте
    if ($status === 'fraud') {
        $client = ClientUAH::where('hash_id', $exchange->client_id)->first();

        if ($client) {
            $currentFraudValue = $client->fraud;
            $client->update([
                'fraud' => $currentFraudValue + 1,
            ]);
        }
    }

    // Запускаем UpdateJob
    UpdateJob::dispatch($exchange->exchange_id);

    if ($exchanges) {
        return ['success' => "Статус обновлен"];
    } else {
        return ['error' => 'Ошибка при обновлении данных'];
    }
}

    
}