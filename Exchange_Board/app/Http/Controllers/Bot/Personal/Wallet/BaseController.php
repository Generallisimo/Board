<?php

namespace App\Http\Controllers\Bot\Personal\Wallet;

use App\Http\Controllers\Controller;
use App\Services\Bot\Personal\Wallet\PersonalServices;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(PersonalServices $service)
    {
        $this->service = $service;
    }
}
