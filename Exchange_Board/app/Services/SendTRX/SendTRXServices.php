<?php

namespace App\Services\SendTRX;

use App\Components\SendToUserTRX\SendTRX;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\User;

class SendTRXServices
{
    public function store(array $data){
        $user = $this->user($data['user_id']);

        $result = (new SendTRX($user->details_from, $data['amount']))->sendTRX();
        
        return $result ? true : false;
    }

    protected function user($hash_id){
        $role = User::where('hash_id', $hash_id)->first();

        if($role->hasRole('agent')){
            return Agent::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('client')){
            return Client::where('hash_id', $hash_id)->first();
        }elseif($role->hasRole('market')){
            return Market::where('hash_id', $hash_id)->first();
        }
    }
}