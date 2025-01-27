<?php

namespace App\Jobs\Exchange;

use App\Components\CheckBalance\CheckBalance;
use App\Components\CheckTXID\CheckTXID;
use App\Components\SendPercent\SendPercent;
use App\Components\SendToUserTRON\SendTRON;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Exchange;
use App\Models\Market;
use App\Models\Platform;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $exchange;
    public $timeout = 350;
    public $tries = 1;

    public function __construct($exchange)
    {
        $this->exchange = $exchange;    
    }

    public function handle(): void
    {
        $response = Exchange::where('exchange_id', $this->exchange)->first();

        $client = Client::where('hash_id', $response->client_id)->first();

        $market = Market::where('hash_id', $response->market_id)->first();
        $agent = Agent::where('hash_id', $market->agent_id)->first();

        $platform = Platform::find(1);
           
        if($response->result === 'to_success'){

            $sendAgent = (new SendPercent(
                $response->amount_agent,
                $agent->details_from,
                $market->details_from,
                $market->private_key
            ))->update();
            Log::info($sendAgent['success']);
            $sendPlatform = (new SendPercent(
                $response->amount_client,
                $platform->details_from,
                $market->details_from,
                $market->private_key
            ))->update();

            $sendClient = (new SendPercent(
                $response->result_client,
                $client->details_from,
                $market->details_from,
                $market->private_key
            ))->update();

            if($sendAgent['success'] && $sendClient['success'] && $sendPlatform){
                $this->store(
                    $this->exchange,
                    $sendAgent['transaction'],
                    $sendAgent['owner'],
                    $sendAgent['address_to'],
                    $sendAgent['amount'],
                    'success'
                );

                $this->store(
                    $this->exchange,
                    $sendPlatform['transaction'],
                    $sendPlatform['owner'],
                    $sendPlatform['address_to'],
                    $sendPlatform['amount'],
                    'success'
                );

                $this->store(
                    $this->exchange,
                    $sendClient['transaction'],
                    $sendClient['owner'],
                    $sendClient['address_to'],
                    $sendClient['amount'],
                    'success'
                );

                new CheckBalance($client);
                new CheckBalance($market);
                new CheckBalance($platform);
                new CheckBalance($agent);

                $response->update([
                    'result'=>'success',
                    'message'=>'successful'
                ]);
            }elseif($sendAgent['success'] === false || $sendClient['success'] === false || $sendPlatform['success'] === false){
                $this->store(
                    $this->exchange,
                    $sendAgent['transaction'],
                    $sendAgent['owner'],
                    $sendAgent['address_to'],
                    $sendAgent['amount'],
                    'error'
                );

                $this->store(
                    $this->exchange,
                    $sendPlatform['transaction'],
                    $sendPlatform['owner'],
                    $sendPlatform['address_to'],
                    $sendPlatform['amount'],
                    'error'
                );

                $this->store(
                    $this->exchange,
                    $sendClient['transaction'],
                    $sendClient['owner'],
                    $sendClient['address_to'],
                    $sendClient['amount'],
                    'error'
                );

                new CheckBalance($client);
                new CheckBalance($market);
                new CheckBalance($platform);
                new CheckBalance($agent);

                $response->update(['result'=>'error', 'message'=>'Ошибка транзакции']);
            }

        }
    }

    private function store($exchange_id, $transaction_id, $owner, $adress_to, $amount, $status){
        Transaction::create([
            'exchange_id'=>$exchange_id,
            'transaction_id'=>$transaction_id,
            'owner_address'=>$owner,
            'address_to'=>$adress_to,
            'amount'=>$amount,
            'status'=>$status
        ]);
    }
}