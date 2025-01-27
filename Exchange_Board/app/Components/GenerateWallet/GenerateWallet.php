<?php

namespace App\Components\GenerateWallet;

use Illuminate\Support\Facades\Http;

class GenerateWallet{
    public function createWallet()
    {
        $tronHost = config('tron.host'); 

        return Http::post($tronHost . '/create');
    }
}