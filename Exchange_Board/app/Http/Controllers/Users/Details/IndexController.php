<?php

namespace App\Http\Controllers\Users\Details;

use App\Http\Controllers\Users\Details\BaseController;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $data = $this->service->create();

        return view ('pages.Users.Details.create', compact('data'));
    }
}
