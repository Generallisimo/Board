@extends('layouts.app', ['page' => __('Переводы'), 'pageSlug' => 'send'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Переводы</h5>
            </div>
            <div class="table-responsive">
            <table class="table" id="clients">
                <thead>
                    <tr>
                        <th>Exchange_id</th>
                        <th>Transaction_id</th>
                        <th>Отправитель</th>
                        <th>Получатель</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $item)
                    <tr>
                        <td>{{$item->exchange_id}}</td>
                        <td>{{$item->transaction_id}}</td>
                        <td>{{$item->owner_address}}</td>
                        <td>{{$item->address_to}}</td>
                        <td>{{$item->amount}}</td>
                        <td>{{$item->status}}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection