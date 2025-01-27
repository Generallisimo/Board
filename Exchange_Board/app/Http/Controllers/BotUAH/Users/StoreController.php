<?php

namespace App\Http\Controllers\BotUAH\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\BotUAH\Users\StoreRequest;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //добавить другую валидацию
        // $data = $request->validated();
        $data = [
            //добавить генерацию
            "hash_id" => $request->input('hash_id'),
            "password" => $request->input('password'),
            "role" => $request->input('role'),
            "details_to" => $request->input('details_to'),
            "percent" => $request->input('percent'),
            "agent_id" => $request->input('agent_id'),
        ];

        $result = $this->service->store($data);
        // $result = true;
        
        if($result === true){
            return response()->json(['success'=> 'пользователь создан']);
        }else{
            return response()->json(['error'=>'Произошла ошибка при создание пользователя']);
        }
    }
}
