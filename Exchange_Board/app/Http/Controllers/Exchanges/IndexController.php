<?php

namespace App\Http\Controllers\Exchanges;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exchanges\IndexRequest;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($exchange_id)
    {  
        $data = $this->service->index($exchange_id);
        Log::info("getDataStatusApiExchange: ", $data);
        return response()->json(['status'=>$data['status']]);


        // $data = $indexRequest->input('callback');
        
        // $result = $this->service->index($client_id, $amount, $currency, $data);
        
        // if($result['success']){
        //     return view('pages.Exchanges.index', compact('result'));
        // }else{
        //     return view('pages.Exchanges.error.error_market');
        // }
    }
}
