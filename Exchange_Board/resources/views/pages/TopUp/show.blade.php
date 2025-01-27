@extends('layouts.app', ['page' => __('Пополнение'), 'pageSlug' => 'top up'])

@section('content')

    <div class="row">
        <div class="col-md-6" style="margin: 100px auto;">
            <div class="card">
                <div class="card-header">
                    <h5 class="title text-center">Статус платежа</h5>
                </div>
                <div class="status">
                    <input hidden value="{{$data['hash_id']}}" name="hash_id">
                    <div class="form-group ml-5 mr-5 mb-5">
                        <label>Кошелек для оплаты:</label>
                        <input type="text" name="wallet" class="form-control" placeholder="введите сумму для пополнения" value="{{$data['wallet']}}" style="pointer-events: none;">
                    </div>

                    <h1 class="status-text text-center">Платеж обрабатывается</h1>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.apiUrl = "{{ config('app.api_local') }}";
    </script>
    <script src="{{ asset('js') }}/checkTopUp/CheckTopUp.js"></script>

@endsection