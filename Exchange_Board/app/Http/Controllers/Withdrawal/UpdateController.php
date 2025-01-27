<?php

namespace App\Http\Controllers\Withdrawal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Withdrawal\UpdateRequest;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $updateRequest)
    {
        //add currency validate
        $data = $updateRequest->validated();

        $result = $this->service->update($data);
        if($result === true){
            return redirect()->back()->with('success', 'Вывод средств успешен!');
        }else{
            // add message with problem, now all 200 OK if have TRX
            return redirect()->back()->withErrors(['error'=>$result]);
        }
    }
}
