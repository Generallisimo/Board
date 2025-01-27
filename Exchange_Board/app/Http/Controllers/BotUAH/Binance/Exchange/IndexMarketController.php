<?php

namespace App\Http\Controllers\BotUAH\Binance\Exchange;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexMarketController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $market_id = $request->input('market_id');
        $status = $request->input('status');

        $data = $this->services->indexMarket($market_id, $status);

        if($data['success']){
            return response()->json(['success'=>$data['success']]);
        }else{
            return response()->json(['success'=>$data['error']]);
        }
    }
}
