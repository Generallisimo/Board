<?php

namespace App\Http\Controllers\Bot\Personal\Details\Card;

use App\Http\Controllers\Bot\Personal\Details\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bot\Personal\Details\Card\StoreRequest;
use App\Models\MethodPayments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        $data = $storeRequest->validated();

        $result = $this->service->store($data);

        if($result === true){
            return response()->json(['success'=> 'Реквезиты успешно добавлены!']);
        }else{
            return response()->json(['error'=>'Произошла ошибка при создание реквезитов']);
        }
    }
}
