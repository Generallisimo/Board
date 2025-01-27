<?php

namespace App\Http\Controllers\Bot\Personal\Wallet;

use App\Http\Controllers\Bot\Personal\Wallet\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bot\Personal\Wallet\UpdateRequest;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $updateRequest)
    {
        $data = $updateRequest->validated();
        
        $result = $this->service->update($data);

        if($result){
            return response()->json(['success'=> 'Данные кошелька успешно обновлнены']);
        }else{
            return response()->json(['error'=>'Ошибка обратитесь в техническую поддержку']);
        }
    }
}
