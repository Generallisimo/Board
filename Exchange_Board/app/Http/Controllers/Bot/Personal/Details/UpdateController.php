<?php

namespace App\Http\Controllers\Bot\Personal\Details;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($detail_id)
    {
        $data = $this->service->update($detail_id);

        if($data['success']){
            return response()->json(['success'=>'статус карты успешно был изменен']);
        }else{
            return response()->json(['error'=>'Ошибка при изменение статуса карты']);
        }
    }
}
