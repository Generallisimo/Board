<?php

namespace App\Http\Controllers\Money;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $transactions = Transaction::all();

        return view('pages.Money.index', compact('transactions'));
    }
}
