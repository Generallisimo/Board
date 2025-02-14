@extends('layouts.app', ['page' => __('Переводы'), 'pageSlug' => 'send'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Переводы</h5>
            </div>
            <div class="table-responsive">
            @if($transactions['data']->isEmpty())
            <p class="text-center mt-4">Пока нет переводов</p>
            @else
            <table class="table" id="clients">
                <thead>
                    <tr>
                        <th>Exchange ID</th>
                        @if(Auth::user()->hasRole('admin'))
                            <th>User ID</th>
                            <th>Роль пользователя</th>
                        @endif
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions['data'] as $item)
                    <tr>
                        <td>{{$item->exchange_id}}</td>
                        @if(Auth::user()->hasRole('admin'))
                            <td>{{$item->user_id}}</td>
                            <td>{{$item->user_role}}</td>
                        @endif
                        <td>{{$item->amount}}</td>
                        <td>{{$item->status}}</td>
                        <td>{{$item->created_at}}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection