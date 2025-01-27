@extends('layouts.payments.app')


@section('content')
<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">

                    @if($exchange_id)
                        <form action="{{ route('support.show', ['chat_id' => $exchange_id]) }}">
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
                <input hidden name="exchange_id" value="{{$exchange_id}}">
                <div class="card-header">
                    <h5 class="title text-center">Статус платежа</h5>
                </div>
                <div class="status">
                    <h1 class="status-text text-center">Платеж обрабатывается</h1>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.apiUrl = "{{ config('app.api_local') }}";
    </script>
    <script src="{{ asset('js') }}/CheckStatusExchange/CheckStatus.js"></script>
@endsection