<?php

namespace App\Http\Controllers\Exchanges;

use Illuminate\Http\Request;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($client_id, $amount, $currency,)
    {
        
        $result = $this->service->show($client_id, $amount, $currency);
        // dd($result);
        if($result['success'] === true){
            return view('pages.Exchanges.show', compact('result'));
        }else{
            return view('pages.Exchanges.error.error_market');
        }
    }
}
