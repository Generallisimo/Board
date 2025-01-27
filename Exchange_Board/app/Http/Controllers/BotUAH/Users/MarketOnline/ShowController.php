<?php

namespace App\Http\Controllers\BotUAH\Users\MarketOnline;

use App\Http\Controllers\Controller;
use App\Models\MarketUAH;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = MarketUAH::where('status', 'online')->get();

        if($data){
            return response()->json(['success'=>$data]);
        }else{
            return response()->json(['error'=>"ошибка получение менял"]);
        }
    }
}
