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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>Произошла ошибка, обратитесь в поддержку</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header">
                    <h5 class="title text-center">Подтверждение платежа</h5>
                </div>
                <div class="card-footer">
                    <button onclick="window.history.back()" class="btn btn-primary btn-round">Назад</button>
                </div>
                <form method="POST" action="{{route('payment.store', ['exchange_id'=>$result['exchange_id']])}}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                    
                    <input hidden name="client_id" value="{{$result['client']}}">
                    <input hidden name="market_id" value="{{$result['market']}}">
                    <input hidden name="agent_id" value="{{$result['agent']}}">
                    <input hidden name="amount" value="{{$result['amount']}}">
                    <input hidden name="percent_client" value="{{$result['percent_client']}}">
                    <input hidden name="percent_market" value="{{$result['percent_market']}}">
                    <input hidden name="percent_agent" value="{{$result['percent_agent']}}">
                    <input hidden name="method" value="{{$result['method']}}">
                    <input hidden name="currency" value="{{$result['currency']}}">
                    <input hidden name="result_client" value="{{$result['result_client']}}">
                    <input hidden name="amount_client" value="{{$result['amount_exchange']}}">
                    <input hidden name="amount_market" value="{{$result['amount_market']}}">
                    <input hidden name="amount_agent" value="{{$result['amount_agent']}}">
                    <input hidden name="callback" value="{{$result['callback']}}">


                    <div class="form-group">
                        <label for="exampleInputEmail1">Сумма к отправлению</label>
                        <input  class="form-control" name="amount_users" value="{{$result['amount_users']}}" style="pointer-events: none;">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Адресс получателя</label>
                        <input  class="form-control" name="details_market_payment" value="{{$result['wallet_market']['details_market_to']}}" style="pointer-events: none;">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Комментарий от получателя</label>
                        <input  class="form-control" value="{{$result['wallet_market']['comment']}}" style="pointer-events: none;">
                    </div>
                        
                    <div class="form-group">
                        <label for="photo">Загрузить фото подтверждения</label>
                        <input type="file" class="form-control" name="photo" id="photoInput">
                    </div>
                    <div class="form-group">
                        <img id="photoPreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
                    </div>

                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-fill btn-primary">Оплатил</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    <script>
        document.getElementById('photoInput').addEventListener('change', function(event) {
        var input = event.target;
        var file = input.files[0];
        
        if (file) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var preview = document.getElementById('photoPreview');
                preview.src = e.target.result;
                preview.style.display = 'block'; // Показываем изображение
            };
            
            reader.readAsDataURL(file); // Читаем файл как Data URL
        } else {
            var preview = document.getElementById('photoPreview');
            preview.src = '#';
            preview.style.display = 'none'; // Скрываем изображение, если файл не выбран
        }
    });
    </script>
@endsection