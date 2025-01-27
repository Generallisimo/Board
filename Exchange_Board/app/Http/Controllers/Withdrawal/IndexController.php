<?php

namespace App\Http\Controllers\Withdrawal;

use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $data = $this->service->index();

        return view('pages.Withdrawals.index', compact('data'));
    }
}
