<?php

namespace App\Http\Controllers\BotUAH\Users;

use App\Models\User;
use App\Models\AgentUAH;
use App\Models\Platform;
use App\Models\ClientUAH;
use App\Models\MarketUAH;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // изменить на правильную валидацию
        $hash_id = $request->input('hash_id');

        Log::info("Данные о хэше", ['hash_id'=>$hash_id]);

        $user = User::where('hash_id', $hash_id)->first();

        $data = $this->getUserRole($hash_id);
        return response()->json(
            [
                'success'=> true,
                'user' => $data
            ], 200);
    
    }

    protected function getUserRole($hash_id){
        $user = User::where('hash_id', $hash_id)->first();
    
        if ($user->hasRole('admin')) {
            $user = Platform::where('hash_id', $hash_id)->first();
            return [
                'user'=>$user
            ];
        } elseif ($user->hasRole('client_uah')) {
            $user = ClientUAH::where('hash_id', $hash_id)->first();
            return [
                'user'=>$user
            ];
        } elseif ($user->hasRole('market_uah')) {
            $user = MarketUAH::where('hash_id', $hash_id)->first();
            return [
                'user'=>$user
            ];
        } elseif ($user->hasRole('agent_uah')) {
            $user = AgentUAH::where('hash_id', $hash_id)->first();
            return [
                'user'=>$user
            ];
        }

        return null;
    }
}
