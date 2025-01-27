<?php

namespace App\Http\Controllers\Bot\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bot\Transaction\TransactionResource;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($exchange_id)
    {
        $data = $this->service->show($exchange_id);

        if($data['success']){
            // dd($data['message']);
            return (new TransactionResource($data['message']))->resolve();
        }else{
            return `ошибка получения данных о транзакциях exchange_id`;
        }
    }
}
