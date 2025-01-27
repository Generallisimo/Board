<?php

namespace App\Services\Users\Table;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Support;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TableServices
{
    public function index(){
        $clients = Client::all();
        $agents = Agent::all();
        $users = User::all();
        $supports = Support::all();
        
        $user = Auth::user();

        if ($user->hasRole('agent')) {
            $markets = Market::where('agent_id', $user->hash_id)->get();    
        }else{
            $markets = Market::all();
        }

        return [
            'clients'=>$clients,
            'agents'=>$agents,
            'markets'=>$markets,
            'users'=>$users,
            'supports'=>$supports,
        ];

    }

    public function edit($hash_id){
        $userRole = User::where('hash_id', $hash_id)->first();
        // dd($userRole);

        if($userRole->hasRole('client')){
            $user = Client::where('hash_id', $hash_id)->first();
        }elseif ($userRole->hasRole('agent') || $userRole->hasRole('admin')){
             //add validate for admin user
            $user = Agent::where('hash_id', $hash_id)->first();
        }elseif($userRole->hasRole('market')){
            $user = Market::where('hash_id', $hash_id)->first();
        }

        return $user;
    }

    public function update($hash_id, array $data_request){

        $role = User::where('hash_id', $hash_id)->first();

        if($role->hasRole('client')){
            
            Client::where('hash_id', $hash_id)->update([
                'details_from'=> $data_request['details_from'],
                'details_to'=> $data_request['details_to'],
                'percent'=> $data_request['percent'],
                'private_key'=> $data_request['private_key'],
            ]);

            //add validate for admin user
        }elseif($role->hasRole('agent') || $role->hasRole('admin')){
            
            Agent::where('hash_id', $hash_id)->update([
                'details_from'=> $data_request['details_from'],
                'details_to'=> $data_request['details_to'],
                'percent'=> $data_request['percent'],
                'private_key'=> $data_request['private_key'],
            ]);

        }elseif($role->hasRole('market')){
            
            Market::where('hash_id', $hash_id)->update([
                'details_from'=> $data_request['details_from'],
                'details_to'=> $data_request['details_to'],
                'percent'=> $data_request['percent'],
                'private_key'=> $data_request['private_key'],
            ]);

        }

    }
}