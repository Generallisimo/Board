<?php

namespace App\Http\Controllers\Bot\Personal\Details;

use App\Http\Controllers\Controller;
use App\Services\Bot\Personal\Details\PersonalServices;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(PersonalServices $service)
    {
        $this->service = $service;
    }
}
