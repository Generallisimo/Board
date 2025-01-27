<?php

namespace App\Http\Controllers\TopUp;

use App\Http\Controllers\Controller;
use App\Services\TopUp\TopUpServices;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(TopUpServices $service)
    {
        $this->service = $service;
    }
}
