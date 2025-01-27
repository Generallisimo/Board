<?php

namespace App\Http\Controllers\Users\Table;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DestroyController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($hash_id)
    {
        $user = User::where('hash_id', $hash_id)->firstOrFail();        

        if($user->delete()){
            return redirect()->back()->with('successful', 'Пользователь был удален');
        }else{
            return redirect()->back()->withErrors(['destroy_user'=> 'Ошибка, обратитесь в тех. поддержку']);
        }
    }
}
