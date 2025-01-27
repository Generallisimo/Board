<?php

namespace App\Http\Controllers\BotUAH\Users;

use App\Http\Controllers\Controller;
use App\Models\AgentUAH;
use App\Models\ClientUAH;
use App\Models\MarketUAH;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // изменить на правильную валидацию
        $hash_id = $request->input('hash_id');
        $password = $request->input('password');
        
        Log::info($hash_id);
        Log::info($password);
        $user = User::where('hash_id', $hash_id)->first();

        if (!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }

        if (!Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Неверный пароль'], 401);
        }

        $data = $this->getUserRole($hash_id);
        return response()->json(
            [
                'success'=> true,
                'role' => $data['role'],
                'details_from' => $data['details_from'],
                'details_to' => $data['details_to'],
            ], 200);
    
    }

    protected function getUserRole($hash_id){
        $user = User::where('hash_id', $hash_id)->first();
    
        if ($user->hasRole('admin')) {
            $user = Platform::where('hash_id', $hash_id)->first();
            return [
                'role'=>'admin',
                'details_from'=>$user->details_from,
                'details_to'=>$user->details_to
            ];
        } elseif ($user->hasRole('client_uah')) {
            $user = ClientUAH::where('hash_id', $hash_id)->first();
            return [
                'role'=>'client_uah',
                'details_from'=>$user->details_from,
                'details_to'=>$user->details_to
            ];
        } elseif ($user->hasRole('market_uah')) {
            $user = MarketUAH::where('hash_id', $hash_id)->first();
            return [
                'role'=>'market_uah',
                'details_from'=>$user->details_from,
                'details_to'=>$user->details_to
            ];
        } elseif ($user->hasRole('agent_uah')) {
            $user = AgentUAH::where('hash_id', $hash_id)->first();
            return [
                'role'=>'agent_uah',
                'details_from'=>$user->details_from,
                'details_to'=>$user->details_to
            ];
        }

        return null;
    }
}
 