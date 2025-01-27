<?php

namespace App\Http\Controllers\Users\Table\Market\Wallet;

use App\Http\Controllers\Controller;
use App\Services\Users\Table\Market\Wallet\WalletServices;

class BaseController extends Controller
{
    public $service;

    public function __construct(WalletServices $service)
    {
        $this->service = $service;
    }
}