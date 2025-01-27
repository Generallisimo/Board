<?php

namespace App\Http\Controllers\ApiExchange;

use App\Http\Controllers\Controller;
use App\Services\ApiExchange\ApiExchangesServices;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;
    
    public function __construct(ApiExchangesServices $service)
    {
        $this->service = $service;   
    }
}
