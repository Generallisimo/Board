<?php

namespace App\Services\BotUAH\Binance\P2P;

use App\Models\AgentUAH;
use App\Models\MarketUAH;
use App\Models\ExchangeUAH;
use Illuminate\Support\Str;
use App\Models\AddMarketDetailsUAH;
use App\Models\ClientUAH;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class P2PServices
{
    public function index(){
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
            'Content-Type' => 'application/json',
        ])->post('https://p2p.binance.com/bapi/c2c/v2/friendly/c2c/adv/search', [
            'asset' => 'USDT',
            'fiat' => 'UAH',
            'tradeType' => 'SELL',
            'publisherType' => null,
            'page' => 1,
            'rows' => 5,
            'payTypes' => [],
        ]);

        if ($response->successful()) {
            $data = $response->json();
        
            // Проверяем наличие данных
            if (isset($data['data']) && !empty($data['data'])) {
                // Извлекаем цены из массива
                $prices = collect($data['data'])->pluck('adv.price')->map(function ($price) {
                    return (float) $price; // Преобразуем цену в float
                });
        
                // Вычисляем среднее значение
                $averagePrice = $prices->average();
        
                return ['success' => $averagePrice];
            }
        
            return ['error' => 'No data found'];
        }
        return response()->json([
            'error' => 'Failed to fetch data',
            'details' => $response->body()
        ], $response->status());
    }

    public function store($market_id, $price_UAH, $amount_UAH){
        $market = MarketUAH::where('hash_id', $market_id)->first();
        $agent = AgentUAH::where('hash_id', $market->agent_id)->first();
        $detailsMarket = AddMarketDetailsUAH::where('hash_id', $market->hash_id)->first();
        Log::info($market);
        Log::info($detailsMarket);

        $exchange_id = Str::uuid()->toString();
        $amount_USDT = $amount_UAH / $price_UAH;
        
        $agent_amount = $amount_USDT * $agent->percent / 100;
        $market_amount = $amount_USDT * $market->percent / 100;

        $exchange = ExchangeUAH::create([
            'exchange_id'=>$exchange_id,
            'market_id'=>$market->hash_id,
            'market_percent'=>$market->percent,
            'market_amount'=>$market_amount,
            'market_details_from'=>$market->details_from, 
            'agent_id'=>$agent->hash_id,
            'agent_percent'=>$agent->percent,
            'agent_amount'=>$agent_amount,
            'agent_details_from'=>$agent->details_from,
            'amount_USDT'=>$amount_USDT,
            'amount_UAH'=>$amount_UAH,
            'price_UAH'=>$price_UAH,
            // 'add_details_market'=>$detailsMarket->details_market_to,
            'result'=>'active',
            'message'=>'Сделка активная'
        ]);

        if($exchange){
            return [
                'success'=>'Сделка создана'
            ];
        }else{
            return [
                'error'=>'Ошибка при создании сделки'
            ];
        }
    }

    public function update($client_id, $id, $add_details_client, $add_method_client){
        $client = ClientUAH::where('hash_id', $client_id)->first();
        if (!$client) {
            return [
                'error' => 'Клиент не найден',
            ];
        }

        $amount_USDT = ExchangeUAH::where('id', $id)->first();
        $client_amount = $amount_USDT * $client->percent / 100;

        $exchange = ExchangeUAH::where('id', $id)->update([
            'client_id'=>$client->hash_id,
            'client_percent'=>$client->percent,
            'client_amount'=>$client_amount,
            'add_details_client'=>$add_details_client,
            'add_method_client'=>$add_method_client,
            'client_details_from'=>$client->details_from,
            'result'=>'wait'
        ]);

        if($exchange){
            return [
                'success'=>'Сделка в состояние ожидания подтвержения'
            ];
        }else{
            return [
                'error'=>'Ошибка при создании сделки'
            ];
        }
    }
}