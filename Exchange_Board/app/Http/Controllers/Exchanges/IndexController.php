<?php

namespace App\Http\Controllers\Exchanges;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exchanges\IndexRequest;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($client_id, $amount, $currency, IndexRequest $indexRequest)
    {
        $data = $indexRequest->validated();
        
        $result = $this->service->index($client_id, $amount, $currency, $data);
        
        if($result['success']){
            return view('pages.Exchanges.index', compact('result'));
        }else{
            return view('pages.Exchanges.error.error_market');
        }
    }
}
