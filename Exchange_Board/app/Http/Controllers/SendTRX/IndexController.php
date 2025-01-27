<?php

namespace App\Http\Controllers\SendTRX;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $users = User::where('hash_id', '!=', 'platform')
            ->whereDoesntHave('roles', function ($query){
                $query->where('name', 'support');
            })
            ->get();

        return view('pages.SendTRX.index', compact('users'));
    }
}
