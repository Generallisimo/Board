<?php

namespace App\Http\Controllers\Users\Table;

use App\Http\Controllers\Controller;
use App\Services\Users\Table\TableServices;

class BaseController extends Controller
{
    public $service;

    public function __construct(TableServices $service)
    {
        $this->service = $service;
    }
}