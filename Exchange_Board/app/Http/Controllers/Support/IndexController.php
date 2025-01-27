<?php

namespace App\Http\Controllers\Support;

use App\Models\Chat;
use App\Models\Message;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        // $data = Message::all();

        // reverse
        $data = Chat::orderBy('created_at', 'desc')->get();
        foreach ($data as $chat) {
            $status = Message::where('chat_id', $chat->chat_id)
            ->orderBy('created_at', 'desc')
            ->first();
            $chat->status = $status ? $status->status : false;
        }
        // dd($data);
        return view('pages.Support.index', compact('data'));
    }
}
