<?php

namespace App\Http\Controllers\BotUAH\Binance\Exchange;

use App\Http\Controllers\Controller;
use App\Models\ExchangeUAH;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $status = $request->input('status');

        $data = ExchangeUAH::where('result', $status)->get();

        if($data){
            return response()->json(['success'=>$data]);
        }else{
            return response()->json(['error'=>'ошибка получения сделок']);
        }
    }
}
