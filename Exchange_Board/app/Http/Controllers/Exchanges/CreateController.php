<?php

namespace App\Http\Controllers\Exchanges;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exchanges\CreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CreateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($client_id, $amount, $currency, $market_id, $exchange_id, CreateRequest $createRequest)
    {
        $data = $createRequest->validated();
        // dd($data);

        $result = $this->service->create(
            $client_id, $amount,
            $currency, $market_id,
            $exchange_id, $data
        );

        if($result['success'] === false){
            return redirect()->back()->withErrors(['error'=>"Обратитесь в поддержку, произошла ошибка"]);
        }else{
            return view('pages.Exchanges.create', compact('result'));
        }
    }
}
