@extends('layouts.payments.app')


@section('content')
<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">

                    @if($result['exchange_id'])
                        <form action="{{ route('support.show', ['chat_id' => $result['exchange_id']]) }}">
                            <li class="search-bar input-group">
                                <p class="mt-2">Техническая поддержка</p>
                                <button class="btn btn-link" id="search-button" data-toggle="modal" data-target="#searchModal">
                                    <i class="tim-icons icon-chat-33"></i>
                                </button>
                            </li>
                        </form>
                    @endif
                
            </ul>
        </div>
    </div>
</nav>
<div class="row">
    <div class="col-md-6" style="margin: 100px auto;">
        <div class="card">
        @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif
            <div class="card-header">
                <h5 class="title text-center" style="font-size: 30px;">Оплата</h5>
            </div>
            <form 
                method="get" 
                action="{{route(
                    'payment.create', 
                    [
                        'client'=>$result['client_id'], 
                        'amount'=>$result['amount'], 
                        'currency'=>$result['currency'],
                        'market'=>$result['market_id'],
                        'exchange_id'=>$result['exchange_id']
                    ]
                )}}" 
                autocomplete="off">
                @csrf
                <div class="card-body">

                    <input hidden value="{{$result['callback']}}" name="callback">

                    @error('callback')
                        <div class="text-danger text-center">{{$message}}</div>
                    @enderror

                    <div class="form-group text-center" style="display: grid;">
                        <label for="method">Выбор метода</label>
                        <div id="method-options" class="btn-group" role="group" style="margin: 0 auto;">
                            @foreach($result['unique_method'] as $name)
                            <input type="button" class="btn btn-outline-secondary method-btn" value="{{ $name->name_method }}" onclick="setMethod('{{ $name->name_method }}')">
                            @endforeach
                        </div>
                        <input type="hidden" name="method" id="method">
                    </div>

                    @error('method')
                        <div class="text-danger text-center">Выберите метод оплаты!</div>
                    @enderror



                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-fill btn-primary">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="{{ asset('js') }}/exchanges/SelectMethodIndex.js"></script>
@endsection