<?php

namespace App\Http\Controllers\ApiExchange;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($exchange_id)
    {
        $data = $this->service->update($exchange_id);

        return response()->json($data['message']);
    }
}
