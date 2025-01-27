<?php

namespace App\Http\Controllers\ApiExchange;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($currency, $amount, $api_key)
    {
        $data = $this->service->store($currency, $amount, $api_key);

        if($data['success']){
            return response()->json($data);
        }else{
            abort(403, 'Нет доступа к этому api');
        }
    }
}
