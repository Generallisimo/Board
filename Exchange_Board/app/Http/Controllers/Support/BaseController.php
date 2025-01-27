<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Services\Support\SupportService;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(SupportService $service)
    {
        $this->service = $service;
    }
}
