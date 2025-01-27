<?php

namespace App\Services\BotUAH\Users;

use App\Models\AddMarketDetails;
use App\Models\MethodPayments;
use Illuminate\Support\Facades\Log;
use App\Components\CheckBalance\CheckBalance;
use App\Components\GenerateWallet\GenerateWallet;
use App\Components\SendToUserTRX\SendTRX;
use App\Http\Requests\Users\StoreUsersRequest;
use App\Models\Agent;
use App\Models\AgentUAH;
use App\Models\Client;
use App\Models\ClientUAH;
use App\Models\Market;
use App\Models\MarketUAH;
use App\Models\Support;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UsersServices
{
    public function store(array $data_request){

        // if($data_request['role'] === 'support'){
        //     $user = User::create([
        //         'hash_id'=>$data_request['hash_id'],
        //         'password'=>$data_request['password']
        //     ]);
            
        //     $user->assignRole($data_request['role']);

        //     $this->createSupport(
        //         $data_request['hash_id']   
        //     );

        //     return true;
        // }else{

            $response = new GenerateWallet();
            $generate_data = $response->createWallet();
    
            
            if ($generate_data->successful()){
                $data = $generate_data->json();
    
                $sendTRX = new SendTRX($data['address'], '200');
                $resultTrx = $sendTRX->sendTRX();
    
                if($resultTrx === true){
                    
                    $user = User::create([
                        'hash_id'=>$data_request['hash_id'],
                        'password'=>$data_request['password']
                    ]);
            
                    $user->assignRole($data_request['role']);
                    
                    if($user->hasRole('agent_uah')){
                        $this->createAgent(
                            $data_request['hash_id'], 
                            $data['address'], 
                            $data_request['details_to'], 
                            $data_request['percent'],
                            $data['privateKey']    
                        );
                    }elseif($user->hasRole('market_uah')){
                        $this->createMarket(
                            $data_request['hash_id'], 
                            $data['address'], 
                            $data_request['details_to'], 
                            $data_request['percent'],
                            $data_request['agent_id'],
                            $data['privateKey']    
                        );
                        // $hash_id, $details_from, $details_to, $percent, $private_key, $agent_id){
                    }elseif($user->hasRole('client_uah')){
                        $this->createClient(
                            $data_request['hash_id'], 
                            $data['address'], 
                            $data_request['details_to'], 
                            $data_request['percent'],
                            $data['privateKey'],
                            $data_request['agent_id'],
                        );
                    };
    
                    return true;
                }else{
                    return 'Ошибка при отправке TRX: ';
                }

            }
        // }        
    }

    protected function createAgent($hash_id, $details_from, $details_to, $percent, $private_key){
        $agent = AgentUAH::create([
            'hash_id' => $hash_id,
            'balance'=>'0',
            'details_from'=>$details_from,
            'details_to'=>$details_to,
            'percent'=>$percent,
            'private_key'=>$private_key,
        ]);

        new CheckBalance($agent);
    }

    
    protected function createMarket($hash_id, $details_from, $details_to, $percent, $agent_id, $private_key){
        $market = MarketUAH::create([
            'hash_id' => $hash_id,
            'balance'=>'0',
            'details_from'=>$details_from,
            'details_to'=>$details_to,
            'percent'=>$percent,
            'agent_id'=>$agent_id,
            'private_key'=>$private_key,
        ]);

        new CheckBalance($market);
    }

    // protected function createSupport($hash_id){
    //     Support::create([
    //         'hash_id' => $hash_id,
    //     ]);
    // }

    
    protected function createClient($hash_id, $details_from, $details_to, $percent, $private_key, $agent_id){
        
        $api_key = Str::random(15);

        $client = ClientUAH::create([
            'hash_id' => $hash_id,
            'balance'=>'0',
            'details_from'=>$details_from,
            'details_to'=>$details_to,
            'percent'=>$percent,
            // 'api_link'=>$hash_id,
            // 'api_key'=>$api_key,
            'private_key'=>$private_key,
            'agent_id'=>$agent_id,
        ]);

        new CheckBalance($client);
    }
}