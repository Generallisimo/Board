<?php

namespace App\Http\Controllers\BotUAH\Balance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $wallet = $request->input('wallet');
        $hash_id = $request->input('hash_id');

        $result = $this->services->store($wallet, $hash_id);

        return response()->json($result['result']);
    }
}
