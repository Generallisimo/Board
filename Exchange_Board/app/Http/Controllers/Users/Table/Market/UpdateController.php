<?php

namespace App\Http\Controllers\Users\Table\Market;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($hash_id)
    {
        $this->service->update($hash_id);

        return redirect()->back()->with('successful', 'Статус обменника обнавлён!');
    }
}
