<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($exchange_id, $status, $message)
    {
        
        $result = $this->service->update($exchange_id, $status, $message);
        // dd($result);
        if($result === true){
            return redirect()->back()->with('successful', 'Данные о транзакции обновлены!');
        }else{
            return redirect()->back()->withErrors(['transactions_error'=>$result]);
        }
    }
}
