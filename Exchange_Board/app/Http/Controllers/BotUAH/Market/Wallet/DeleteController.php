<?php

namespace App\Http\Controllers\BotUAH\Market\Wallet;

use Illuminate\Http\Request;
use App\Models\AddMarketDetailsUAH;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $id = $request->input('id');
        // $details_market_to = $request->input('details_market_to');

        $data = AddMarketDetailsUAH::where('id', $id)->update([
            'status'=>'delete',
        ]);

        if($data){
            return response()->json(['success'=>'Статус карты обнавлен!']);
        }else{
            return response()->json(['error'=>'Ошибка при обнавление статуса карты']);
        }
    }
}
