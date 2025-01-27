<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\Users\UserServices;

class BaseController extends Controller
{
    public $service;

    public function __construct(UserServices $service)
    {
        $this->service = $service;
    }
}