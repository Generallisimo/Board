<?php

namespace App\Http\Controllers\Bot\Transactions;

use App\Http\Controllers\Controller;
use App\Services\Bot\Transaction\TransactionService;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }
}
