<?php

namespace App\Http\Controllers\BotUAH\Binance\Exchange;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $exchange_id = $request->input('id');
        $status = $request->input('status');

        $data = $this->services->update($exchange_id, $status);

        if($data['success']){
            return response()->json(['success'=>$data['success']]);
        }else{
            return response()->json(['success'=>$data['error']]);
        }
    }
}
