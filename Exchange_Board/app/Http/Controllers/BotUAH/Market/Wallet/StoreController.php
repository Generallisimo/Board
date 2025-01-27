<?php

namespace App\Http\Controllers\BotUAH\Market\Wallet;

use Illuminate\Http\Request;
use App\Models\AddMarketDetailsUAH;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $hash_id = $request->input('hash_id');
        $name_method = $request->input('name_method');
        $comment = $request->input('comment');
        $details_market_to = $request->input('details_market_to');

        $data = AddMarketDetailsUAH::create([
            'hash_id'=>$hash_id,
            'name_method'=>$name_method,
            'currency'=>'UAH',
            'comment'=>$comment,
            'details_market_to'=>$details_market_to,
        ]);

        if($data){
            return response()->json(['success'=>'Карта добавлена!']);
        }else{
            return response()->json(['error'=>'Ошибка при добавление карты']);
        }
    }
}
