<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\Exchange\UpdateJob;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($exchange_id, $status, $message)
    {
        Log::info('getUpdateControllerId: ', [$exchange_id]);
        $result = $this->service->update($exchange_id, $status, $message);

        if($result === true){
            return redirect()->back()->with('successful', 'Данные о транзакции обновлены!');
        }else{
            return redirect()->back()->withErrors(['transactions_error'=>$result]);
        }
    }
}
