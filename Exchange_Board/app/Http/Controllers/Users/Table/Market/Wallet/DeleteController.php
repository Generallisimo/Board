<?php

namespace App\Http\Controllers\Users\Table\Market\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $this->service->deleteFake($id);

        return redirect()->back()->with('success', 'Реквезиты удалены');
    }
}
