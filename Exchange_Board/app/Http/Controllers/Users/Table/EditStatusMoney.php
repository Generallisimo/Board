<?php

namespace App\Http\Controllers\Users\Table;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class EditStatusMoney extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $result = Platform::where('hash_id', 'platform')->first();
        // dd($result);
        if($result->status_commission === 'online'){
            $result->update(['status_commission'=> 'offline']);
            $result->save();
        }else{
            $result->update(['status_commission'=> 'online']);
            $result->save();
        }
        return redirect()->back();
    }
}
