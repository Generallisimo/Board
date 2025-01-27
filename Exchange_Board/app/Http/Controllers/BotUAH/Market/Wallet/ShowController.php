<?php

namespace App\Http\Controllers\BotUAH\Market\Wallet;

use Illuminate\Http\Request;
use App\Models\AddMarketDetailsUAH;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $hash_id = $request->input('hash_id');
    
        $data = AddMarketDetailsUAH::where('hash_id', $hash_id)->whereIn('status', ['online', 'offline'])->get();

        if($data){
            return response()->json(['success'=>$data]);
        }else{
            return response()->json(['error'=>'Ошибка при получение карт']);
        }
    }
}
