<?php

namespace App\Http\Controllers\Money;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $transactions = $this->service->index();
        // dd($transactions);
        // $transactions = Transaction::all();
        // if($transactions === false){
            return view('pages.Money.index', compact('transactions'));
        // }
    }
}
