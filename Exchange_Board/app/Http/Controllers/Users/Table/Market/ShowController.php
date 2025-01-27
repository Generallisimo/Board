<?php

namespace App\Http\Controllers\Users\Table\Market;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($hash_id)
    {
        $data = $this->service->show($hash_id);
        // dd($data);
        if($data['success'] === true){
            return view('pages.Users.Table.Market.show', compact('data', 'hash_id'));
        }else{
            return redirect()->back()->whiteErrors(['error_wallet', 'Вначале нужно завесит реквизиты, что попасть в настройки профиля']);
        }
    }
}
