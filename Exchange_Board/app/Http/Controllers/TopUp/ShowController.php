<?php

namespace App\Http\Controllers\TopUp;

use App\Http\Requests\TopUp\UpdateRequest;

class ShowController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $updateRequest)
    {
        $data = $updateRequest->validated();
        // dd($data);
        return view('pages.TopUp.show', compact('data'));
    }
}
