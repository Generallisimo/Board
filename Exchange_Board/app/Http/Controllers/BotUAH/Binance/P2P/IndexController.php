<?php

namespace App\Http\Controllers\BotUAH\Binance\P2P;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IndexController extends BaseController
{
    public function __invoke(Request $request)
    {
        $data = $this->services->index();

        if($data['success']){
            return response()->json(['success'=>$data]);
        }else{
            return response()->json(['error'=>$data]);
        }
    }
}
