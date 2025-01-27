<?php

namespace App\Http\Controllers\Withdrawal;

use App\Http\Controllers\Controller;
use App\Services\Withdrawals\WithdrawalServices;

class BaseController extends Controller
{
    public $service;

    public function __construct(WithdrawalServices $service)
    {
        $this->service = $service;
    }
}
