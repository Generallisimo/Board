<?php

namespace App\Http\Controllers\Bot\Personal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bot\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($hash_id)
    {
        // $data = $updateRequest->validated();
        // $data['hash_id'] = $hash_id;

        // dd($hash_id);
        $result = $this->service->update($hash_id);
        if($result['success']){
            return response()->json(['success' => 'Статус был обновлен'], 200);
        }else{
            return response()->json(['error'=>'ошибка при изменения статуса', 400]);
        }
    }
}
