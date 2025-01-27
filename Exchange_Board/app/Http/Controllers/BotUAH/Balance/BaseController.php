<?php

namespace App\Http\Controllers\BotUAH\Balance;

use App\Http\Controllers\Controller;
use App\Services\BotUAH\Balance\BalanceServices;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $services;

    public function __construct(BalanceServices $services)
    {
        $this->services = $services;
    }
}
