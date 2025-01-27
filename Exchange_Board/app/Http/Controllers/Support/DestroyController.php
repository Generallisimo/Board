<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class DestroyController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($chat_id)
    {
        $chat = Chat::where('chat_id', $chat_id)->first();

        if($chat->delete()){
            return redirect()->back()->with('successful', 'Чат был удален');
        }else{
            return redirect()->back()->withErrors(['destroy_chat'=> 'Ошибка, обратитесь к администратору']);
        }
    }
}
