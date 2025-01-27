<?php

namespace App\Http\Controllers\BotUAH\Market;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Market;
use App\Models\MarketUAH;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
{
    // Получаем hash_id из запроса
    $hash_id = $request->input('hash_id');

    // Логируем полученные данные
    Log::info('Запрос на изменение статуса:', ['hash_id' => $hash_id]);

    // Проверяем, передан ли hash_id
    if (!$hash_id) {
        Log::error('hash_id не передан в запросе');
        return response()->json(['error' => 'hash_id не передан'], 400);
    }

    // Пытаемся найти запись в базе данных
    $status = MarketUAH::where('hash_id', $hash_id)->first();

    // Проверяем, найдена ли запись
    if (!$status) {
        Log::warning('Запись с таким hash_id не найдена:', ['hash_id' => $hash_id]);
        return response()->json(['error' => 'Запись с таким hash_id не найдена'], 404);
    }

    // Проверяем статус и обновляем
    if ($status->status === 'offline') {
        Log::info('Изменение статуса на online для hash_id:', ['hash_id' => $hash_id]);
        MarketUAH::where('hash_id', $hash_id)->update([
            'status' => 'online',
        ]);
        return response()->json(['success' => 'success']);
    } elseif ($status->status === 'online') {
        Log::info('Изменение статуса на offline для hash_id:', ['hash_id' => $hash_id]);
        MarketUAH::where('hash_id', $hash_id)->update([
            'status' => 'offline',
        ]);
        return response()->json(['success' => 'success']);
    } else {
        Log::error('Некорректный статус для hash_id:', ['hash_id' => $hash_id, 'status' => $status->status]);
        return response()->json(['error' => 'Некорректный статус'], 400);
    }
}


}
