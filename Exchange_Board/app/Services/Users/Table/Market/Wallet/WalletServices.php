<?php

namespace App\Services\Users\Table\Market\Wallet;

use App\Models\AddMarketDetails;
use App\Models\Market;

class WalletServices
{
    public function update(array $data_request){

        AddMarketDetails::where('id', $data_request['id'])->update([
            'details_market_to'=>$data_request['details_market_to'],
        ]);

    }

    public function updateStatus($id){
        $status = AddMarketDetails::where('id', $id)->first();
        
        if($status->online === 'offline'){
            AddMarketDetails::where('id', $id)->update([
                'online'=> 'online',
            ]);
        }elseif($status->online === 'online'){
            AddMarketDetails::where('id', $id)->update([
                'online'=> 'offline',
            ]);
        }
    }

    public function deleteFake($id){
        AddMarketDetails::where('id', $id)->update([
            'online'=>'deleted'
        ]);
    }
}