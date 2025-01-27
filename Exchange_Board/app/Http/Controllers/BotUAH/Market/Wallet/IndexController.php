<?php

namespace App\Http\Controllers\BotUAH\Market\Wallet;

use Illuminate\Http\Request;
use App\Models\AddMarketDetailsUAH;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $id = $request->input('id');

        $data = AddMarketDetailsUAH::where('id', $id)->first();

        if($data){
            return response()->json(['success'=>$data]);
        }else{
            return response()->json(['error'=>'Ошибка при поиске карты']);
        }
    }
}
