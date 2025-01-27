<?php

namespace App\Services\Bot\Personal\Wallet;

use App\Models\Agent;
use App\Models\Market;
use App\Models\Client;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PersonalServices
{
    public function update(array $data){
        $user = $this->userDetails($data['hash_id'], $data['details_to']);
        // Log::info($data['details_to']);
        return $user? true: false;
    }

    protected function userDetails($hash_id, $details_to){
        $userId = User::where('hash_id', $hash_id)->first();

        if(!$userId){
            return false;
        }

        if($userId->hasRole('admin')){
            $user = Platform::where('hash_id', $userId->hash_id)->update([
                'details_to'=>$details_to
            ]);
        }elseif($userId->hasRole('agent')){
            $user = Agent::where('hash_id', $userId->hash_id)->update([
                'details_to'=>$details_to
            ]); 
        }elseif($userId->hasRole('market')){
            $user = Market::where('hash_id', $userId->hash_id)->update([
                'details_to'=>$details_to
            ]); 
        }elseif($userId->hasRole('client')){
            $user = Client::where('hash_id', $userId->hash_id)->update([
                'details_to'=>$details_to
            ]); 
        }

        return $user? true : false;
    }
}