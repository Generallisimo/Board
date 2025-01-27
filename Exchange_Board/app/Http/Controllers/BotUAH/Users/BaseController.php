<?php

namespace App\Http\Controllers\BotUAH\Users;

use App\Http\Controllers\Controller;
use App\Services\BotUAH\Users\UsersServices;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(UsersServices $service)
    {
        $this->service = $service;
    }
}
