<?php

namespace App\Http\Controllers\BotUAH\Binance\Exchange;

use App\Http\Controllers\Controller;
use App\Services\BotUAH\Binance\Exchange\ExchangeServices;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $services;

    public function __construct(ExchangeServices $services)
    {
        $this->services = $services;
    }
}
