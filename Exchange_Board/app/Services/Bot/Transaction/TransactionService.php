<?php

namespace App\Services\Bot\Transaction;

use App\Models\Exchange;

class TransactionService
{
    public function index($status){
        $exchange = Exchange::where('result', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(2);

        if($exchange){
            return [
                'success'=>true,
                'data'=>$exchange
            ];
        }
        return [
            'success'=>false,
        ];
    }

    public function show($exchange_id){
        $exchange = Exchange::where('exchange_id', $exchange_id)->first();
        // dd($exchange);
        if($exchange){
            return[
                'success'=>true,
                'message'=>$exchange
            ];
        }else{
            return [
                'success'=>false,
            ];
        }
    }
}