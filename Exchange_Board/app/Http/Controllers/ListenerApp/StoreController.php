<?php

namespace App\Http\Controllers\ListenerApp;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = $request->all();
        $apiKey = $data['apiKey'] ?? null;
        $notification = $data['notifcations'][0] ?? null;

        if (!$apiKey || !$notification) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $contentText = $notification['contentText'] ?? '';
        preg_match('/(\d+\.\d+)UAH/', $contentText, $amountMatches);
        $amount = (float) $amountMatches[1];

        $transaction = Exchange::where('amount_users', $amount)->first();

        return response()->json(['all'=>$transaction]);
        // return response()->json(['all'=>$all, 'api'=>$apiKey]);
    }
}
