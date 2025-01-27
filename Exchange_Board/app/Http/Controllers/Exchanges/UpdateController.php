<?php

namespace App\Http\Controllers\Exchanges;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($exchange)
    {
        $data = $this->service->update($exchange);
        
        return response()->json(['status'=>$data['message']]);
    }   
}
