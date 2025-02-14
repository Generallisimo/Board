<?php

namespace App\Services\Users\Table\Market;

use App\Models\Market;
use App\Models\MarketStatus;
use App\Models\AddMarketDetails;
use Carbon\Carbon;

class MarketServices
{
    public function show($hash_id){
        $market_details = AddMarketDetails::where('hash_id', $hash_id)->whereIn('online', ['online', 'offline'])->get();
        $market_details_delete = AddMarketDetails::where('hash_id', $hash_id)->where('online', 'deleted')->get();
        $market = Market::where('hash_id', $hash_id)->first();
    
        if (!$market) {
            return [
                'success' => false,
            ];
        }
    
        // Получаем все статусы (онлайн и оффлайн) по маркету
        $statuses = MarketStatus::where('market_id', $market->id)
            ->orderBy('changed_at')
            ->get();
    
        $total_online_time = 0;
        $last_online_time = null;
    
        foreach ($statuses as $status) {
            if ($status->status === 'online') {
                $last_online_time = $status->changed_at; // Запоминаем, когда маркет был включен
            } elseif ($status->status === 'offline' && $last_online_time) {
                // Если есть закрытая пара (online -> offline), считаем разницу
                $total_online_time += $last_online_time->diffInSeconds($status->changed_at);
                $last_online_time = null; // Сбрасываем, так как маркет теперь оффлайн
            }
        }
    
        // Если маркет остался онлайн и не было "offline", учитываем время до настоящего момента
        if ($last_online_time) {
            $total_online_time += $last_online_time->diffInSeconds(Carbon::now());
        }
    
        $total_online_time_in_hours = gmdate("H:i:s", $total_online_time); // форматируем в часы:минуты:секунды
    
        return [
            'success' => true,
            'market_details' => $market_details,
            'market_details_delete' => $market_details_delete,
            'market' => $market,
            'online_time' => $total_online_time_in_hours,
        ];
    }
    

    public function edit($id){
        $market_details = AddMarketDetails::where('id', $id)->first();

        return [
            'market_details'=>$market_details,
        ];
    }

    public function update($hash_id){
        $market = Market::where('hash_id', $hash_id)->firstOrFail();

        // Переключаем статус
        $newStatus = $market->status === 'offline' ? 'online' : 'offline';
    
        // Обновляем статус в Market
        $market->update(['status' => $newStatus]);
    
        // Логируем смену статуса
        MarketStatus::create([
            'market_id' => $market->id,
            'status' => $newStatus, // Теперь записываем новый статус
            'changed_at' => Carbon::now(),
        ]);
    }
}