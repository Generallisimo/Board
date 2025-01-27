<?php

namespace App\Http\Controllers\Users\Details;

use App\Http\Controllers\Controller;
use App\Services\Users\NewDetailsService;

class BaseController extends Controller
{
    public $service;

    public function __construct(NewDetailsService $service)
    {
        $this->service = $service;
    }
}