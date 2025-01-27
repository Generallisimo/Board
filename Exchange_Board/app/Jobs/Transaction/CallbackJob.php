<?php

namespace App\Jobs\Transaction;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CallbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $callback;
    public $status;

    /**
     * Create a new job instance.
     */
    public function __construct($callback, $status)
    {   
        $this->callback = $callback;
        $this->status = $status;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            Http::timeout(1)->async()->post($this->callback, [
                'status'=>$this->status
            ])->wait();
        }catch(Exception $e){
            Log::error("Error with callback: " . $e->getMessage());
        }
    }
}
