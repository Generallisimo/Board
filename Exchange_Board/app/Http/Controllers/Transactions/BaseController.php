<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Services\Transactions\TransactionServices;

class BaseController extends Controller
{
    public $service;

    public function __construct(TransactionServices $service)
    {
        $this->service = $service;
    }
}