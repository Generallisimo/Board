<?php

namespace App\Http\Controllers\Money;

use App\Http\Controllers\Controller;
use App\Services\Money\Services;

class BaseController extends Controller
{
    public $service;

    public function __construct(Services $services)
    {
        $this->service = $services;
    }
}