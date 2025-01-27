<?php

namespace App\Http\Controllers\Users\Table\Market\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\Table\Market\Wallet\BaseController;
use App\Http\Requests\Users\Table\Market\UpdateRequest;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $updateRequest)
    {
        $data = $updateRequest->validated();

        $this->service->update($data);
        
        return redirect()->back()->with('successful', 'Данные об карте были обновлены');
    }
}
