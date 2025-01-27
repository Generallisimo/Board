<?php

namespace App\Services\Bot\Personal;

use App\Models\AddMarketDetails;
use App\Models\Market;

class PersonalServices
{
    public function index($hash_id){
        $market = Market::where('hash_id', $hash_id)->first();
        $details_market = AddMarketDetails::where('hash_id', $hash_id)->whereIn('online', ['online', 'offline'])->get();
        // dd($market, $details_market);
        // dd($market);
        if($market){
            return [
                'success'=>true,
                'data'=> $market,
                'details'=>$details_market
            ];
        }else{
            return [
                'success'=>false
            ];
        }
    }


    public function update($hash_id){
        // dd($data);
        $status = Market::where('hash_id', $hash_id)->first();
        if ($status) {
            if ($status->status === 'offline') {
                Market::where('hash_id', $hash_id)->update(['status' => 'online']);
            } elseif ($status->status === 'online') {
                Market::where('hash_id', $hash_id)->update(['status' => 'offline']);
            }
            return ['success' => true];
        }
    
        return ['success' => false];
    }
}