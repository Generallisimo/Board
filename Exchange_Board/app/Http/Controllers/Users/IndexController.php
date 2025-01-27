<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        // create validate on hash_id
        $data = $this->service->create();

        // dd($data);
        return view('pages.Users.create', compact('data'));
    }
}
