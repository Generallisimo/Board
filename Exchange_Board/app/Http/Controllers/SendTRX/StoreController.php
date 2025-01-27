<?php

namespace App\Http\Controllers\SendTRX;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendTRX\StoreRequest;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        $data = $storeRequest->validated();
        $result = $this->service->store($data);

        if($result){
            return redirect()->back()->with('success', 'TRX успешно отправлен пользователю');
        }else{
            return redirect()->back()->withErrors(['error'=>'Ошибка перевода, обратитесь в тех поддержку']);
        }
    }
}
