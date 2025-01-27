<?php

namespace App\Http\Controllers\BotUAH\Market\Withdrawal;

use App\Http\Controllers\Controller;
use App\Models\MarketUAH;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $hash_id = $request->input('hash_id');
        $details_to = $request->input('details_to');

        $data = MarketUAH::where('hash_id', $hash_id)->update([
            'details_to'=>$details_to,
        ]);

        if($data){
            return response()->json(['success'=>'Карта обнавлена!']);
        }else{
            return response()->json(['error'=>'Ошибка при обнавление карты']);
        }
    }
}
