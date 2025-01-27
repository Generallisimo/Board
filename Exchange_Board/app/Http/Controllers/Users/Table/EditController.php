<?php

namespace App\Http\Controllers\Users\Table;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($hash_id)
    {
        
        $user = $this->service->edit($hash_id);
        
        return view('pages.Users.Table.edit', compact('hash_id', 'user'));

        //add to html.blade
        // if ($user === null) {
        //     return redirect()->back()->withErrors(['error' => 'Роль пользователя не найдена']);
        // }

    }
}
