<?php

namespace App\Http\Controllers\Bot\Personal\Details\Card;

use App\Http\Controllers\Bot\Personal\Details\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bot\Personal\Details\UpdateRequest;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $updateRequest)
    {
        $data = $updateRequest->validated();
        $result = $this->service->updateCard($data);

        if($result['success']){
            return response()->json(['success'=>'данные о реквезитах успешно обнавлены']);
        }
        return response()->json(['error'=>'ошибка при обнавление данных реквезитов']);
    }
}
