<?php

namespace App\Http\Controllers\SendTRX;

use App\Http\Controllers\Controller;
use App\Services\SendTRX\SendTRXServices;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    public $service;

    public function __construct(SendTRXServices $service)
    {
        $this->service = $service;
    }
}
