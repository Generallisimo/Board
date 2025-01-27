<?php

namespace App\Http\Controllers\Users\Table\Market;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        
        $data = $this->service->edit($id);
        // dd();
        
        return view('pages.Users.Table.Market.edit', compact('data'));
    }
}
