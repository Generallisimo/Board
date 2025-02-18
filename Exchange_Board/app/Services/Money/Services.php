<?php

namespace App\Services\Money;

use App\Models\Market;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;


class Services
{
    public function index(){
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $data = Transaction::latest()->get();
            // dd($data);
        }elseif($user->hasRole('market')){
            $data = Transaction::where('user_id', $user->hash_id)->latest()->get();

        }elseif($user->hasRole('client')){
            $data = Transaction::where('user_id', $user->hash_id)->latest()->get();
        }elseif($user->hasRole('agent')){
            $data = Transaction::where('user_id', $user->hash_id)->latest()->get();
        }
        return [
            'data'=>$data
        ];
    }

    // public function show($market_id){
    //     // $data = Transaction::where('market_id', $market_id)->get();

    //     // return [
    //     //     'transaction'=>$data
    //     // ];
    // }
}