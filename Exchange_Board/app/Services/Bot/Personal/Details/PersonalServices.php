<?php

namespace App\Services\Bot\Personal\Details;

use App\Models\AddMarketDetails;
use App\Models\MethodPayments;
use Illuminate\Support\Facades\Log;

class PersonalServices
{
    public function show($detail_id){
        $detail = AddMarketDetails::where('details_market_to', $detail_id)->first();

        if($detail){
            return[
                'success'=>true,
                'message'=>$detail
            ];
        }else{
            return [
                'success'=>false,
            ];
        }
    }

    public function store(array $data_request){
        
        $currencyMethod = MethodPayments::where('name_method', $data_request['name_method'])->first();
        $currency = $currencyMethod->currency;

        $result = $this->newDetails(
            $data_request['hash_id'], 
            $data_request['details_market_to'], 
            $data_request['name_method'],
            $currency,
            $data_request['comment']
        );
    
        if($result === true){
            return true;
        }else{
            return "Ошибка добавления карты обратитесь в поддержку";
        }
       
    }

    protected function newDetails($hash_id, $details_to, $name_method, $currency, $comment){

        $newDetail = AddMarketDetails::create([
            'hash_id' => $hash_id,
            'details_market_to' => $details_to,
            'name_method' => $name_method,
            'currency' => $currency,
            'comment' => $comment,
        ]);

        return $newDetail ? true : false;
    }

    public function update($detail_id){
        // dd($data);
        $status = AddMarketDetails::where('details_market_to', $detail_id)->first();
        if ($status) {
            if ($status->online === 'offline') {
                AddMarketDetails::where('details_market_to', $detail_id)->update(['online' => 'online']);
            } elseif ($status->online === 'online') {
                AddMarketDetails::where('details_market_to', $detail_id)->update(['online' => 'offline']);
            }
            return ['success' => true];
        }
    
        return ['success' => false];
    }

    public function delete($detail_id){
        $status = AddMarketDetails::where('details_market_to', $detail_id)->first();

        if($status){
            AddMarketDetails::where('details_market_to', $detail_id)->update(['online'=>'delete']);
            return ['success'=>true];
        }

        return ['success'=>false];
    }

    public function updateCard(array $data){
        $detail = AddMarketDetails::where('id', $data['id'])->update([
            'details_market_to'=>$data['detail_id']
        ]);
        if($detail){
            return ['success'=>true];
        }

        return ['success'=>false];
    }
}