<?php

namespace App\Http\Controllers\Exchanges;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exchanges\StoreRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($exchange_id, StoreRequest $storeRequest)
    {
        $data = $storeRequest->validated();


        $fileUrl = null;
        if ($storeRequest->hasFile('photo')) {
            $file = $storeRequest->file('photo');
            $filePath = $file->store('public/paymentScreens');
            $fileUrl = Storage::url($filePath);
        }
        $data['photo'] = $fileUrl;
        $result = $this->service->store($exchange_id, $data);

        return view('pages.Exchanges.store', compact('result', 'exchange_id'));
    }
}
