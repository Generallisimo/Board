<?php

namespace App\Http\Controllers\Exchanges;

use App\Http\Controllers\Controller;
use App\Services\Exchanges\ExchangeServices;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(ExchangeServices $service)
    {
        $this->service = $service;
    }
}
