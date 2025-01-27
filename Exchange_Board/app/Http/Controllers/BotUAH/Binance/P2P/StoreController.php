<?php

namespace App\Http\Controllers\BotUAH\Binance\P2P;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $market_id = $request->input('market_id');
        $price_UAH = $request->input('price_UAH');
        $amount_UAH = $request->input('amount_UAH');

        $data = $this->services->store($market_id, $price_UAH, $amount_UAH);

        if($data['success']){
            return response()->json(['success'=>'Сделка создана']);
        }else{
            return response()->json(['error'=>'Ошибка при создании']);
        }
    }
}
