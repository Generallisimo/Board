@extends('layouts.app', ['page' => __('Вывод'), 'pageSlug' => 'withdrawal'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                </div>
            @endif
            <div class="card-header">
                <h5 class="title">Вывод Средств</h5>
            </div>
            <form method="post" action="{{route('withdrawal.update')}}" autocomplete="off">
                @csrf
                <div class="card-body">

                    <input name="hash_id" value="{{$data['user']->hash_id}}" hidden>
                    @error('hash_id')
                        <div class="text-danger">{{$message}}</div>
                    @enderror

                    <div class="form-group">
                        <label>На балансе</label>
                        <input type="text" name="send_currency" class="form-control" value="{{$data['user']->balance}}" style="pointer-events: none;">
                    </div>

                    <div class="form-group">
                        <label>Реквезиты для вывода</label>
                        <input type="text" name="you_send_details" class="form-control" value="{{$data['user']->details_to}}" style="pointer-events: none;">
                    </div>
                    @error('you_send_details')
                        <div class="text-danger">{{$message}}</div>
                    @enderror

                    <div class="form-group">
                        <label>Сумма для вывода, комиссия 5 долларов </label>
                        <input type="text" name="you_send" class="form-control" placeholder="введите сумму для вывода">
                    </div>
                    @error('you_send')
                        <div class="text-danger">{{$message}}</div>
                    @enderror


                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Выбор валюты для вывода</label>
                        <select class="form-control" id="get_currency" name="currency_coin">
                            <option value="USDT">USDT</option>
                            <!-- <option value="XMR">XMR</option> -->
                        </select>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">Продолжить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection