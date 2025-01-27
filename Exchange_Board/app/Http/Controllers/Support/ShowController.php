<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Guest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $chat_id)
    {
        
        $chat = Chat::where('chat_id', $chat_id)->first();

        $guest = Guest::where('ip', $request->ip())->first();
        $user = Auth::user();


        $user_id = $user ? $user->hash_id : ($guest ? $guest->hash_id : null);

        if (!$chat) {
            if ($user) {
                $send_id = $user_id;
                $name = $this->user($user->hash_id)['name'];
            } else {
                $send_id = $guest->hash_id;
                $name = 'пользователь';

            }

            $chat = Chat::create([
                'chat_id' => $chat_id,
                'send_id' => $send_id,
                'name' => $name
            ]);
        }

        $isSupport = $user ? $user->hasRole('support') || $user->hasRole('admin') : false;

        if (!$isSupport && $chat->send_id !== $user_id) {
            abort(403, 'Нет доступа к этому чату');
        }
        if ($isSupport) {
            Message::where('chat_id', $chat_id)
                ->where('send_id', '!=', $user_id)
                ->where('status', true)
                ->update(['status' => false]);
        }
        $messages = Message::where('chat_id', $chat_id)->get();
        // dd($chat_id);

        return view('pages.Support.show', compact('messages', 'chat', 'user_id', 'isSupport'));
    }

    protected function user($hash_id){
        $role = User::where('hash_id', $hash_id)->first();

        if($role->hasRole('client')){
            return ['name'=>'клиент'];
        }elseif($role->hasRole('agent')){
            return ['name'=>'куратор'];
        }elseif($role->hasRole('market')){
            return ['name'=>'обменник'];
        }elseif($role->hasRole('admin')){
            return ['name'=>'администратор'];
        }elseif($role->hasRole('support')){
            return ['name'=>'поддержка'];
        }
    }
}
