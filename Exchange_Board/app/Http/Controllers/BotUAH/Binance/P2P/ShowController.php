<?php

namespace App\Http\Controllers\BotUAH\Binance\P2P;

use App\Models\ExchangeUAH;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $id = $request->input('id');
        $exchange = ExchangeUAH::where('id', $id)->first();

        if($exchange){
            return response()->json(['success'=>$exchange]);
        }else{
            return response()->json(['error'=>'ошибка при поиске транзаций']);
        }
    }
}
