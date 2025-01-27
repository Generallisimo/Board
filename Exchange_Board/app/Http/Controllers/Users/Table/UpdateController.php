<?php

namespace App\Http\Controllers\Users\Table;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Table\UpdateTableRequest;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($hash_id, UpdateTableRequest $updateTableRequest)
    {
        $data = $updateTableRequest->validated();

        $this->service->update($hash_id, $data);

        return redirect()->route('table.users.index');
    }
}
