<?php

namespace App\Http\Controllers\BotUAH\Market\Wallet;

use App\Http\Controllers\BotUAH\Market\BaseController;
use App\Http\Controllers\Controller;
use App\Models\AddMarketDetailsUAH;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $id = $request->input('id');
        // $hash_id = $request->input('hash_id');
        $details_market_to = $request->input('details_market_to');

        $data = AddMarketDetailsUAH::where('id', $id)->update([
            'details_market_to'=>$details_market_to,
        ]);

        if($data){
            return response()->json(['success'=>'Карта обнавлена!']);
        }else{
            return response()->json(['error'=>'Ошибка при обнавление карты']);
        }
    
    }
}
