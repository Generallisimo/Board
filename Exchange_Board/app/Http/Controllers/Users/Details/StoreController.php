<?php

namespace App\Http\Controllers\Users\Details;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Detials\StoreRequest;
use App\Services\Users\NewDetailsService;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRequest $serviceNewDetails)
    { 
        $data = $serviceNewDetails->validated();
        $result = $this->service->store($data);

        if($result === true){
            return redirect()->back()->with('successful', 'Реквезиты успешно добавлены!');
        }else{
            return redirect()->back()->withErrors(['details_error'=>$result]);
        }
    }
}
