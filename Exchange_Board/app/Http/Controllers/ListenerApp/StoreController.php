<?php

namespace App\Http\Controllers\ListenerApp;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\Models\Market;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use App\Models\Agent;
use App\Models\ProfitUser;
use App\Models\Transaction;
use Carbon\Carbon;
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

        $transaction = Exchange::where('amount_users', $amount)->where('result', 'await')->where('market_api_key', $apiKey)->first();

        //добавить логику переводов 

        
        if($transaction){
            Exchange::where('exchange_id', $transaction['exchange_id'])->update([
                'result'=>'success',
                'message'=>'Сумма оплачена'
            ]);

            $marketCash = Market::where('hash_id', $transaction->market_id)->first();
            $amountAll = $transaction->amount;
            $checkBalance = $marketCash->balance_hold < $amountAll; 
            Log::info("getMarketBalance: ", [$checkBalance]);
            
            if($checkBalance){
                Exchange::where('exchange_id', $transaction->exchange_id)->update([
                    'result'=>'error',
                    'message'=>'ошибка перевода'
                ]);
                return false;
            }
            
            // заработок куратора / возможно платформе в роли куратора
            Agent::where('hash_id', $transaction->agent_id)->increment('balance', $transaction->amount_agent);
            // заработок менялы
            Market::where('hash_id', $transaction->market_id)->increment('balance', $transaction->amount_market);
            // снимаем деньги с холда
            Market::where('hash_id', $transaction->market_id)->decrement('balance_hold', $transaction->amount);
            // заработок клиента
            Client::where('hash_id', $transaction->client_id)->increment('balance', $transaction->result_client);
            // заработок платформу от процента на клиент
            Agent::where('hash_id', 'platform')->increment('balance', $transaction->amount_client);

            // деньги менялы
            $this->storeTransaction($transaction->exchange_id, $transaction->market_id, 'меняла', $transaction->amount, 'отправлено');
            $this->storeTransaction($transaction->exchange_id, $transaction->market_id, 'меняла', $transaction->amount_market, 'доход');
            // деньги клиента
            $this->storeTransaction($transaction->exchange_id, $transaction->client_id, 'клиент', $transaction->result_client, 'доход');
            // деньги куратора
            $this->storeTransaction($transaction->exchange_id, $transaction->agent_id, 'куратор', $transaction->amount_agent, 'доход');
            // деньги платформы
            $this->storeTransaction($transaction->exchange_id, 'platform', 'платформа', $transaction->amount_client, 'доход');
        
            //доход клиента
            $this->storeProfit($transaction->client_id, $transaction->result_client);
            //доход менялы
            $this->storeProfit($transaction->market_id, $transaction->amount_market);
            //доход платформы
            $this->storeProfit('platform', $transaction->amount_client);
            //доход куратора
            $this->storeProfit($transaction->agent_id, $transaction->amount_agent);

            return response()->json(['status'=>$transaction]);
        }
        return response()->json(['status'=>'ошибка в транзакции']);
 
    }

    protected function storeTransaction($exchange_id, $user_id, $user_role, $amount, $status ){
        Transaction::create([
            'exchange_id'=>$exchange_id,
            'user_id'=>$user_id,
            'user_role'=>$user_role,
            'amount'=>$amount,
            'status'=>$status
        ]);
    }

    protected function storeProfit($hash_id, $amount_profit){
        ProfitUser::create([
            'hash_id'=>$hash_id,
            'amount_profit'=>$amount_profit,
            'changed_at'=>Carbon::now(),
        ]);
    }
}
