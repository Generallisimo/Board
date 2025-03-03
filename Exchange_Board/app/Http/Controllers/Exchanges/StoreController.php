<?php

namespace App\Http\Controllers\Exchanges;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exchanges\StoreRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($client_id, $amount, $currency)
    {
        $result = $this->service->store($client_id, $amount, $currency);
        // dd($result);
        if($result['success'] === true){
            return response()->json($result);
        }else{
            return response()->json($result, 400);
        }
    }
}