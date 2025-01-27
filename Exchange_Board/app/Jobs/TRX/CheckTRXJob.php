<?php

namespace App\Jobs\TRX;

use App\Components\CheckTRXBalance\CheckTRXBalance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckTRXJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $wallet;
    /**
     * Create a new job instance.
     */
    public function __construct($wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Выполняем проверку баланса
        $check = (new CheckTRXBalance($this->wallet))->update();
        Log::info("TRX balance: " . json_encode(['result' => $check['message']['result']['balance']]));
    
        // Проверяем баланс и решаем, нужно ли повторно отправлять задачу
        if ($check['message']['result']['balance'] < 100) {
            // Ожидание 3 минуты перед повторной отправкой
            Log::info("Balance below 100 TRX. Retrying in 3 minutes.");
            self::dispatch($this->wallet)->delay(now()->addMinutes(3));
        } else {
            Log::info("Balance sufficient. No need to retry.");
        }
    }
    
}
