<?php

namespace App\Http\Controllers\Support;

use App\Events\Support\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Guest;
use App\Models\Market;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // $user = $request->send_id;
        // $send_id = $user ? $user->hash_id : Guest::where('ip', $request->ip())->first()->hash_id;
        $user_id = $request->send_id;
        $user = User::where('hash_id', $user_id)->first();
       
        if(!$user){
            $name = 'пользователь';
        }else{
            $name = $this->user($user->hash_id)['name'];
        }
        $isSupport = $user && ($user->hasRole('support') || $user->hasRole('admin'));

        $message = Message::create([
            'chat_id'=> $request->chat_id,
            'name'=> $name,
            'send_id'=>$request->send_id,
            'messages'=>$request->message,
            'status'=>!$isSupport 
        ]);

        broadcast(new SendMessage($message))->toOthers();

        return response()->json(['status' => 'Message sent successfully']);
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

    // add to components
    // protected function user($hash_id){
    //     $role = User::where('hash_id', $hash_id)->first();

    //     if($role->hasRole('client')){
    //         return Client::where('hash_id', $hash_id)->first();
    //     }elseif($role->hasRole('agent') || $role->hasRole('admin')){
    //         return Agent::where('hash_id', $hash_id)->first();
    //     }elseif($role->hasRole('market')){
    //         return Market::where('hash_id', $hash_id)->first();
    //     }
    // }
}
