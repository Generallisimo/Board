<?php

namespace App\Jobs\BotUAH\Binance\Exchange;

use App\Models\AgentUAH;
use App\Models\Platform;
use App\Models\ClientUAH;
use App\Models\MarketUAH;
use App\Models\ExchangeUAH;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Components\SendPercent\SendPercent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Components\CheckBalance\CheckBalance;

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

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = ExchangeUAH::where('exchange_id', $this->exchange)->first();

            if (!$response) {
                Log::error('Exchange not found', ['exchange_id' => $this->exchange]);
                return;
            }

            $client = ClientUAH::where('hash_id', $response->client_id)->first();
            $market = MarketUAH::where('hash_id', $response->market_id)->first();
            $agent = AgentUAH::where('hash_id', $market->agent_id)->first();
            $platform = Platform::find(1);

            if (!$client || !$market || !$agent || !$platform) {
                Log::error('Missing dependencies', [
                    'client' => $client,
                    'market' => $market,
                    'agent' => $agent,
                    'platform' => $platform,
                ]);
                return;
            }

            if ($response->result === 'to_success') {
                $sendAgent = (new SendPercent(
                    $response->agent_amount,
                    $agent->details_from,
                    $market->details_from,
                    $market->private_key
                ))->update();

                $sendPlatform = (new SendPercent(
                    $response->client_amount,
                    $platform->details_from,
                    $market->details_from,
                    $market->private_key
                ))->update();

                $sendMarket = (new SendPercent(
                    $response->market_amount,
                    $market->details_from,
                    $client->details_from,
                    $client->private_key
                ))->update();

                if ($sendAgent['success'] && $sendMarket['success'] && $sendPlatform['success']) {
                    $response->update([
                        'result' => 'success',
                        'message' => 'successful',
                    ]);
                    Log::info('Transaction completed successfully', ['exchange_id' => $response->exchange_id]);
                } else {
                    $response->update([
                        'result' => 'error',
                        'message' => 'Ошибка транзакции',
                    ]);
                    Log::warning('Transaction failed', [
                        'sendAgent' => $sendAgent,
                        'sendMarket' => $sendMarket,
                        'sendPlatform' => $sendPlatform,
                    ]);
                }

                // Обновляем балансы
                new CheckBalance($client);
                new CheckBalance($market);
                new CheckBalance($platform);
                new CheckBalance($agent);
            }
        } catch (\Exception $e) {
            Log::error('Job failed with exception', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }


}
