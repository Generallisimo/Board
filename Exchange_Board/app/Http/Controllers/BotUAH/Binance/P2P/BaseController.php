<?php

namespace App\Http\Controllers\BotUAH\Binance\P2P;

use App\Http\Controllers\Controller;
use App\Services\BotUAH\Binance\P2P\P2PServices;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $services;

    public function __construct(P2PServices $services)
    {
        $this->services = $services;
    }
}
