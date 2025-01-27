<?php

namespace App\Http\Controllers\Bot\Personal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bot\Personal\DetailsPersonalResource;
use App\Http\Resources\Bot\Personal\PersonalResource;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($hash_id)
    {
        $data = $this->service->index($hash_id);

        if($data['success']){
            return[
                'account'=> new PersonalResource($data['data']),
                'details_account'=> DetailsPersonalResource::collection($data['details'])
            ];
        }else{
            return response()->json(['error' => 'ошибка получения данных о транзакциях'], 404);
        }
    }
}
