<?php

namespace App\Http\Controllers\Exchanges;

use App\Services\Money\Services;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($exchange, $wallet_id)
    {
        $result = $this->service->show($exchange, $wallet_id);
        
        if($result['success'] === true){
            return view('pages.Exchanges.show', compact('result'));
        }else{
            return view('pages.Exchanges.error.error_market');
        }
    }
}
