<?php

namespace App\Http\Controllers\BotUAH\Users\Wallet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Components\CheckBalance\CheckBalance;
use App\Http\Controllers\BotUAH\Users\BaseController;
use App\Models\AgentUAH;
use App\Models\BotUAHauth;
use App\Models\ClientUAH;
use App\Models\MarketUAH;
use App\Models\Platform;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $hash_id = $request->input('hash_id');
        $role = $request->input('role');

        if($role === 'admin'){
            $platform = Platform::where('hash_id', $hash_id)->first();
            new CheckBalance($platform);
            return [
                'balance'=>$platform['balance'],
            ];
        }elseif($role === 'client_uah'){
            $client = ClientUAH::where('hash_id', $hash_id)->first();
            new CheckBalance($client);
            return [
                'user'=>$client['balance']
            ];
        }elseif($role === 'agent_uah'){
            $agent = AgentUAH::where('hash_id', $hash_id)->first();
            new CheckBalance($agent);
            return [
                'user'=>$agent['balance']
            ];
        }elseif($role === 'market_uah'){
            $market = MarketUAH::where('hash_id', $hash_id)->first();
            new CheckBalance($market);
            return [
                'user'=>$market['balance']
            ];
        }
        

    }

    // protected function user($hash_id, $balance){
    //     return BotUAHauth::where('hash_id', $hash_id)->update([
    //         'balance'=>$balance
    //     ]); 
    // }

    // protected function user($role, $hash_id){
    //     if($role->hasRole('admin')){
    //         return AgentUAH::where('hash_id', $hash_id)->first();
    //     }elseif($role->hasRole('market')){
    //         return MarketUAH::where('hash_id', $hash_id)->first();
    //     }elseif($role->hasRole('market')){
    //         return ClientUAH::where('hash_id', $hash_id)->first();
    //     }elseif($role->hasRole('market')){
    //         return Platform::where('hash_id', $hash_id)->first();
    //     }
    // }
}
