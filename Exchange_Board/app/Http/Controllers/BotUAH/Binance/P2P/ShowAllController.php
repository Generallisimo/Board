<?php

namespace App\Http\Controllers\BotUAH\Binance\P2P;

use App\Http\Controllers\Controller;
use App\Models\ExchangeUAH;
use Illuminate\Http\Request;

class ShowAllController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $exchange = ExchangeUAH::where('result', 'active')->get();

        if($exchange){
            return response()->json(['success'=>$exchange]);
        }else{
            return response()->json(['error'=>'ошибка при поиске транзаций']);
        }
    }
}
