<?php

namespace App\Http\Controllers\Bot\Personal\Details;

use App\Http\Controllers\Controller;
use App\Http\Resources\Bot\Personal\Details\ShowResource;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($detail_id)
    {
        $data = $this->service->show($detail_id);

        if($data['success']){
            // dd($data['message']);
            return (new ShowResource($data['message']))->resolve();
        }else{
            return `ошибка получения данных о деталях реквезита`;
        }
    }
}
