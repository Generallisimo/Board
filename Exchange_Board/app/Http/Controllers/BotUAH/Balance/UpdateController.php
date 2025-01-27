<?php

namespace App\Http\Controllers\BotUAH\Balance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Получаем данные из запроса
        $hash_id = $request->input('hash_id');
        $you_send = $request->input('you_send');
        $you_send_details = $request->input('you_send_details');
    
        // Проверяем, переданы ли все необходимые параметры
        if (!$hash_id || !$you_send || !$you_send_details) {
            return response()->json(['error' => 'Не все обязательные параметры переданы'], 400);
        }
    
        try {
            // Вызываем метод update из сервиса
            $result = $this->services->update($hash_id, $you_send, $you_send_details);
    
            if ($result === true) {
                return response()->json(['success' => 'Вывод средств успешен']);
            } else {
                return response()->json(['error' => $result], 400);
            }
        } catch (\Exception $e) {
            // Логируем ошибку
            Log::error('Ошибка при выводе средств', [
                'hash_id' => $hash_id,
                'you_send' => $you_send,
                'you_send_details' => $you_send_details,
                'exception' => $e->getMessage(),
            ]);
    
            return response()->json(['error' => 'Произошла ошибка на сервере. Попробуйте позже.'], 500);
        }
    }
    
}
