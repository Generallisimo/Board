<?php

namespace App\Http\Controllers\Users\Table\Market\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\Table\Market\Wallet\BaseController;
use Illuminate\Http\Request;

class UpdateStatusController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $this->service->updateStatus($id);

        return redirect()->back()->with('successful', 'Статус карты был обновлён');
    }
}
