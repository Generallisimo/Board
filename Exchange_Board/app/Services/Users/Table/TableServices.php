<?php

namespace App\Services\Users\Table;

use App\Models\User;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Market;
use App\Models\Support;
use App\Models\MarketStatus;
use App\Models\ProfitUser;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class TableServices
{
    public function index() {
        $clients = Client::all();
        $agents = Agent::all();
        $users = User::all();
        $supports = Support::all();
    
        $user = Auth::user();
    
        // Если пользователь - агент, получаем только его маркеты
        if ($user->hasRole('agent')) {
            $markets = Market::where('agent_id', $user->hash_id)->get();    
        } else {
            $markets = Market::all();
        }
    
        // Создаём массив для хранения времени онлайн для каждого маркета
        $marketOnlineTimes = [];
    
        foreach ($markets as $market) {
            $statuses = MarketStatus::where('market_id', $market->id)
                ->orderBy('changed_at')
                ->get();
    
            $total_online_time = 0;
            $last_online_time = null;
    
            foreach ($statuses as $status) {
                if ($status->status === 'online') {
                    $last_online_time = $status->changed_at;
                } elseif ($status->status === 'offline' && $last_online_time) {
                    $total_online_time += $last_online_time->diffInSeconds($status->changed_at);
                    $last_online_time = null; // Сбрасываем, так как маркет ушел в оффлайн
                }
            }
    
            // Если маркет остался в онлайне до конца дня, считаем до текущего момента
            if ($last_online_time) {
                $total_online_time += $last_online_time->diffInSeconds(Carbon::now());
            }
    
            // Форматируем в часы, минуты, секунды
            $marketOnlineTimes[$market->id] = gmdate("H:i:s", $total_online_time);
        }

        // dd($clients, $market, $agents);
        // доход клиент
        $profitClient = $this->foreachUsersProfit($clients);
        // доход маркет
        $profitMarket = $this->foreachUsersProfit($markets);
        // доход агента
        $profitAgent = $this->foreachUsersProfit($agents);

        // dd($profitClient);
        return [
            'clients' => $clients,
            'agents' => $agents,
            'markets' => $markets,
            'users' => $users,
            'supports' => $supports,
            'online_times' => $marketOnlineTimes, // Возвращаем массив с онлайн-временем каждого маркета
            'profit_agent' => $profitAgent,
            'profit_client' => $profitClient,
            'profit_market' => $profitMarket,
        ];
    }
    

    protected function foreachUsersProfit($users){
        $profitData = [];

        foreach($users as $user){
            $profits = ProfitUser::where('hash_id', $user->hash_id)
            ->orderBy('changed_at')
            ->get();
    
            $total_profit = [];
            foreach($profits as $profit){
                // dd($profit->changed_at);
                $date = $profit->changed_at->format('Y-m-d');

                if(!isset($total_profit[$date])){
                    $total_profit[$date] = 0;
                }

                $total_profit[$date] += $profit->amount_profit;
            }

            $profitData[$user->hash_id] = $total_profit;
        }

        return $profitData;
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