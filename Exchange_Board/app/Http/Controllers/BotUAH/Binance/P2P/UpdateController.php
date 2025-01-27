<?php

namespace App\Http\Controllers\BotUAH\Binance\P2P;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $client_id = $request->input('client_id');
        $id = $request->input('id');
        $add_details_client = $request->input('add_details_client');
        $add_method_client = $request->input('add_method_client');

        $data = $this->services->update($client_id, $id, $add_details_client, $add_method_client);

        if (isset($data['success'])) {
            return response()->json(['success' => $data['success']]);
        } elseif (isset($data['error'])) {
            return response()->json(['error' => $data['error']], 400);
        }
    }
}
