<?php

namespace App\Http\Controllers\BotUAH\Binance\Exchange;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $exchange_id = $request->input('id');

        $data = $this->services->show($exchange_id);

        if($data['success']){
            return response()->json(['success'=>$data['success']]);
        }else{
            return response()->json(['success'=>$data['error']]);
        }
    
    }
}
