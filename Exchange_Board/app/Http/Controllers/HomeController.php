<?php

namespace App\Http\Controllers;

use App\Http\Requests\Home\UpdateRequest;
use App\Services\HomeServices;

class HomeController extends Controller
{
    public $service;

    public function __construct(HomeServices $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index()
    {
        $data = $this->service->index();
     
        if($data['success']){
            return view('dashboard', compact('data'));
        }else{
            return redirect()->route('support.index');
        }
    }

    public function show($period, $hash_id){
        $data = $this->service->show($period, $hash_id);

        $dataArray = json_decode($data->getContent(), true);
    
        return response()->json([
            'labels' => $dataArray['labels'] ?? [],
            'values' => $dataArray['values'] ?? [],
        ]);
    }

    public function edit($hash_id){
        $data = $this->service->edit($hash_id);
        // dd($data);
        return view('pages.Users.Home.edit', compact('data'));
    }

    public function update(UpdateRequest $updateRequest){
        $data = $updateRequest->validated();

        $result = $this->service->update($data);

        if($result){
            return redirect()->back()->with('success', 'Данные кошелька успешно обновлнены');
        }else{
            return redirect()->back()->withErrors(['error'=>'Ошибка обратитесь в техническую поддержку']);
        }
    }

}
