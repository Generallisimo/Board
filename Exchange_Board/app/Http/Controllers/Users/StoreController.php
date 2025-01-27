<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUsersRequest;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUsersRequest $serviceUser)
    {
        $data = $serviceUser->validated();
        
        $result = $this->service->store($data);

        if($result === true){
            return redirect()->back()->with('successful', 'Пользователь был создан!');
        }else{
            return redirect()->back()->withErrors(['trx_error' => $result]);
        }
    }
}
