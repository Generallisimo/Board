<?php

namespace App\Http\Controllers\ApiExchange;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($exchange_id)
    {
        $exchange = Exchange::where('exchange_id', $exchange_id)->first();

        return  response()->json([
            'result'=>$exchange->result,
            'message'=>$exchange->message,
        ]);
    }
}
