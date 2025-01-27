@extends('layouts.app', ['page' => __('Транзакции'), 'pageSlug' => 'market board'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if(session('successful'))
                <div class="alert alert-success">
                    {{ session('successful') }}
                </div>
            @endif
            @if($errors->has('transactions_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('transactions_error') }}
                </div>
            @endif
            <div class="card-header">
                <!-- <h5 class="title">All Users</h5> -->
                <div class="text-right">
                    <button id="await_but" type="button" class="btn btn-default">Ожидание</button>
                    <button id="to_success_but" type="button" class="btn btn-default">В обработке</button>
                    <button id="dispute_but" type="button" class="btn btn-default">Диспуты</button>
                    <button id="success_but" type="button" class="btn btn-default">Успешные</button>
                    <button id="archive_but" type="button" class="btn btn-default">Архивированные</button>
                    <button id="error_but" type="button" class="btn btn-default">Ошибка</button>
                    <button id="fraud_but" type="button" class="btn btn-default">Мошенники</button>
                </div>
            </div>
            <div class="table-responsive">
            
                <!-- for all view -->
                
                @include('pages.Transactions.status.dispute', ['exchangesDispute'=>$data['exchangesDispute']])
                @include('pages.Transactions.status.archive', ['exchangesArchive'=>$data['exchangesArchive']])
                @include('pages.Transactions.status.success', ['exchangesSuccess'=>$data['exchangesSuccess']])
                @include('pages.Transactions.status.await', ['exchanges'=>$data['exchanges']])
                @include('pages.Transactions.status.error', ['exchangesError'=>$data['exchangesError']])
                @include('pages.Transactions.status.fraud', ['exchangesFraud'=>$data['exchangesFraud']])
                @include('pages.Transactions.status.to_success', ['exchangesToSuccess'=>$data['exchangesToSuccess']])
           
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js') }}/transactions/SelectTransactionsIndex.js"></script>
@endsection