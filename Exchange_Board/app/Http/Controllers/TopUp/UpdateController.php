<?php

namespace App\Http\Controllers\TopUp;


class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($wallet, $hash_id)
    {
        $result = $this->service->update($wallet, $hash_id);

        return response()->json($result['result']);
    }
}
