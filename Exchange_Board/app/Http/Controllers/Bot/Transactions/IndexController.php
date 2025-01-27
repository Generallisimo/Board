<?php

namespace App\Http\Controllers\Bot\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bot\Transaction\TransactionResource;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($status)
    {
        $data = $this->service->index($status);

        if($data['success']){
            return TransactionResource::collection($data['data'])->response()->getData(true);
        }else{
            return 'ошибка получения данных о транзакциях';
        }
    }
}
