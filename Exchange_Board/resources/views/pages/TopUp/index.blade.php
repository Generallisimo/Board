@extends('layouts.app', ['page' => __('Пополнение'), 'pageSlug' => 'top up'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Пополнение</h5>
            </div>
            <form method="post" action="{{route('top_up.show')}}" autocomplete="off">
                @csrf
                <div class="card-body">

                    <input hidden value="{{$data['user']->hash_id}}" name="hash_id">

                    <div class="form-group">
                        <label>Реквезиты пополнения</label>
                        <input type="text" name="wallet" class="form-control" placeholder="введите сумму для пополнения" value="{{$data['user']->details_from}}" style="pointer-events: none;">
                    </div>
                    @error('wallet')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Выбор валюты</label>
                        <select class="form-control" id="get_currency" name="get_currency">
                            <option value="USDT">USDT</option>
                            <!-- <option value="XMR">XMR</option> -->
                        </select>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">Оплатил</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection