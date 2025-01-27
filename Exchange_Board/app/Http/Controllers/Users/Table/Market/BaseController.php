<?php

namespace App\Http\Controllers\Users\Table\Market;

use App\Http\Controllers\Controller;
use App\Services\Users\Table\Market\MarketServices;
use App\Services\Users\Table\Market\WalletServices;

class BaseController extends Controller
{
    public $service;

    public function __construct(MarketServices $service)
    {
        $this->service = $service;
    }
}