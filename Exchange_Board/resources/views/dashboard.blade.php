@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="container">
        @if(Auth::user()->hasRole('admin'))
        <h3>Смена статуса комиссии</h3>
        <form method="post" action="{{route('admin.status_commission')}}" class="mb-3">
            @csrf
            <button type="submit" class="btn btn-primary">{{$data['user']['status_commission']}}</button>
        </form>
        @endif
        <!-- Раздел 1: Баланс -->
        <div class="row mb-4">
            <div class="col-12">
                <h3>Баланс</h3>
            </div>
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Баланс кошелька</h5>
                        <h3 class="card-title"><i class="tim-icons icon-bank text-info"></i> {{$data['user']->balance}} USDT</h3>
                    </div>
                    <div class="card-body" >
                        <div class="chart-area ml-2" style="height: auto;">
                        @if(Auth::user()->hasRole('market'))
                        <div class="d-flex" style="justify-content: space-around;">
                            <div style="text-align: center">
                                <h5 class="card-category">Реквизиты</h5>
                                <form method="GET" action="{{route('table.user.market.show', ['hash_id'=>$data['user']->hash_id])}}">
                                    @csrf
                                    <button type="submit" rel="tooltip" class="btn btn-info btn-sm btn-icon">
                                        <i class="tim-icons icon-single-02"></i>
                                    </button>
                                </form>
                            </div>
                            <div style="text-align: center">
                                <h5 class="card-category">Статус</h5>
                                <form method="post" action="{{route('table.user.market.update', ['hash_id'=>$data['user']->hash_id])}}" autocomplete="off">
                                    @method('PUT')
                                    @csrf
                                        <button class="btn btn-primary btn-sm">{{$data['user']->status}}</button>
                                </form>
                            </div>
                        </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
       
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Кошелёк для пополнения</h5>
                        <h3 class="card-title"><i class="tim-icons icon-money-coins text-info"></i> {{$data['user']->details_from}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">
                            Кошелёк для вывода 
                            <a href="{{route('home.wallet.edit', ['hash_id'=>$data['user']->hash_id])}}" class="btn btn-success btn-sm btn-icon">                                    
                                <i class="tim-icons icon-settings"></i>
                            </a>
                        </h5>
                        <h3 class="card-title"><i class="tim-icons icon-coins text-info"></i> {{$data['user']->details_to}}</h3>
                    </div>
                </div>
            </div>
        </div>




        @if($data['client'] !== null)
        <div class="row mb-4">
            <div class="col-12">
                <h3>API для приёма оплат</h3>
            </div>
            <div class="col-lg-6">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">REST API</h5>
                        <h3 class="card-title"><i class="tim-icons icon-key-25 text-info"></i>GET запрос на: https://pinprocessing.online/api/pay/{currency}/{amount}/{{$data['client']->api_key}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-area" style="height: 240px;">
                            <ul>
                                <li style="list-style: auto; color: #cfcdcd;">{currency} - принимает значение rub, uah, kzt</br></br>Пример: RUB</li></br>
                                <li style="list-style: auto; color: #cfcdcd;">{amount} - принимает цифровое занчение</br></br>Пример: 2500</li></br>
                                <li style="list-style: auto; color: #cfcdcd;">https://pinprocessing.online/api/pay/show/{exchange_id}</br></br>Проверка статуса транзакции, принимает: {номер транзакции}.</li></br>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
       
            <div class="col-lg-6">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">SCI - СТРАНИЦА ОПЛАТЫ</h5>
                        <h3 class="card-title"><i class="tim-icons icon-key-25 text-info"></i><!--- {{config('url.api_local')}}--->POST запрос на: https://pinprocessing.online/api/payment/store/{{$data['client']->api_link}}/{amount}/{currency}</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-area" style="height: 240px;">
                            <ul>
                                <li style="list-style: auto; color: #cfcdcd;">{amount} - принимает цифровое значение</br></br>Пример: 2500</li></br>
                                <li style="list-style: auto; color: #cfcdcd;">{currency} - принимает значение rub, uah, kzt</br></br>Пример: RUB</li></br>
                                <li style="list-style: auto; color: #cfcdcd;">Передать в JSON - url callback для получения статуса</br></br>Принимает значение: {callback} <br>
								<code>https://pinprocessing.online/api/payment/store/{{$data['client']->api_link}}/2500/RUB</code> <br> В ответ на POST запрос по ссылке вы получаете URL оплаты, который передается пользователю.
								
								</li></br>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif


        @if(Auth::user()->hasRole('admin'))
        <div class="row mb-4">
            <div class="col-12">
                <h3>Статистика балансов</h3>
            </div>
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Общий баланс обменников</h5>
                        <h3 class="card-title"><i class="tim-icons icon-chart-bar-32 text-info"></i> {{$data['sumMarket']}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Общий баланс клиентов</h5>
                        <h3 class="card-title"><i class="tim-icons icon-chart-bar-32 text-info"></i> {{$data['sumClient']}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Общий баланс кураторов</h5>
                    <h3 class="card-title"><i class="tim-icons icon-chart-bar-32 text-info"></i>{{$data['sumAgent']}} </h3>
                </div>
            </div>
        </div>
        @endif


        <div class="row">
            <div class="col-12">
                <h3>Статистика оборота</h3>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="timePeriod">Выберите период:</label>
                    <select id="timePeriod" class="form-control">
                        <option value="day">День</option>
                        <option value="week">Неделя</option>
                        <option value="month">Месяц</option>
                        <option value="year">Год</option>
                    </select>
                </div>
                <canvas id="turnoverChart" width="400" height="200"></canvas>
            </div>
        </div>


        @if($data['client'] !== null)
        <div class="row mb-4">
            <div class="col-12">
                <h3>Сатистика фрода</h3>
            </div>
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Количество фрод транзакций</h5>
                        @if($data['client']->fraud === null)
                        <h3 class="card-title"><i class="tim-icons icon-key-25 text-info"></i>0</h3>
                        @else
                        <h3 class="card-title"><i class="tim-icons icon-key-25 text-info"></i> {{$data['client']->fraud}}</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif


        @if(Auth::user()->hasRole('admin'))
        <div class="row mb-4">
            <div class="col-12">
                <h3>Обменники</h3>
            </div>
            <div class="col-lg-6">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Обменники в сети</h5>
                        <h3 class="card-title"><i class="tim-icons icon-check-2 text-info"></i>{{$data['marketOnlineCount']}} </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <ul>
                                @if($data['marketOnline']->isEmpty())
                                    <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                                @else
                                    @foreach($data['marketOnline'] as $market)
                                        <li style="list-style: auto; color: #cfcdcd;">{{$market->hash_id}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Обменники офлайн</h5>
                        <h3 class="card-title"><i class="tim-icons icon-alert-circle-exc text-info"></i>{{$data['marketOfflineCount']}} </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <ul>
                                @if($data['marketOffline']->isEmpty())
                                    <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                                @else
                                    @foreach($data['marketOffline'] as $market)
                                        <li style="list-style: auto; color: #cfcdcd;">{{$market->hash_id}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-4">
            <div class="col-12">
                <h3>Статистика заявок</h3>
            </div>
            <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Количество заявок в обработке</h5>
                    <h3 class="card-title"><i class="tim-icons icon-bell-55 text-info"></i>{{$data['exchangeAwaitCount']}} </h3>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 240px;">
                        <ul>
                            @if($data['exchangeAwait']->isEmpty())
                                <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                            @else
                                @foreach($data['exchangeAwait'] as $exchange)
                                    <li style="list-style: auto; color: #cfcdcd;">{{$exchange->exchange_id}}</li>                                   
                                @endforeach
                                <div class="text-center">
                                    <a href="{{ route('transaction.index')  }}" class="mt-5 btn btn-primary btn-sm" style="margin: 0 auto;">Посмотреть больше...</a>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Список диспутов</h5>
                    <h3 class="card-title"><i class="tim-icons icon-alert-circle-exc text-info"></i>{{$data['exchangeDisputeCount']}}</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 240px;">
                        <ul>
                            @if($data['exchangeDispute']->isEmpty())
                                <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                            @else
                                @foreach($data['exchangeDispute'] as $exchange)
                                    <li style="list-style: auto; color: #cfcdcd;">{{ $exchange->exchange_id }}</li>
                                @endforeach
                                <div class="text-center">
                                    <a href="{{ route('transaction.index')  }}" class="mt-5 btn btn-primary btn-sm" style="margin: 0 auto;">Посмотреть больше...</a>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category" >Список архива</h5>
                    <h3 class="card-title"><i class="tim-icons icon-book-bookmark text-info"></i>{{$data['exchangeArchiveCount']}}</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 240px;">
                        <ul>
                            @if($data['exchangeArchive']->isEmpty())
                                <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                            @else
                                @foreach($data['exchangeArchive'] as $exchange)
                                    <li style="list-style: auto; color: #cfcdcd;">{{$exchange->exchange_id}}</li>
                                    @endforeach
                                    <div class="text-center">
                                        <a href="{{ route('transaction.index')  }}" class="mt-5 btn btn-primary btn-sm" style="margin: 0 auto;">Посмотреть больше...</a>
                                    </div>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex mb-4">
        <div class="col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Список успешных</h5>
                    <h3 class="card-title"><i class="tim-icons icon-heart-2 text-info"></i>{{$data['exchangeSuccessCount']}}</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 240px;">
                        <ul>
                            @if($data['exchangeSuccess']->isEmpty())
                                <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                            @else
                                @foreach($data['exchangeSuccess'] as $exchange)
                                    <li style="list-style: auto; color: #cfcdcd;">{{$exchange->exchange_id}}</li>
                                @endforeach
                                <div class="text-center">
                                    <a href="{{ route('transaction.index')  }}" class="mt-5 btn btn-primary btn-sm" style="margin: 0 auto;">Посмотреть больше...</a>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Список транзакций с ошибками</h5>
                    <h3 class="card-title"><i class="tim-icons icon-button-power text-info"></i>{{$data['exchangeErrorCount']}}</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 240px;">
                        <ul>
                            @if($data['exchangeError']->isEmpty())
                                <li style="list-style: none; color: #cfcdcd; ">Пусто...</li>
                            @else
                                @foreach($data['exchangeError'] as $exchange)
                                    <li style="list-style: auto; color: #cfcdcd;">{{$exchange->exchange_id}}</li>
                                @endforeach
                                <div class="text-center">
                                    <a href="{{ route('transaction.index')  }}" class="mt-5 btn btn-primary btn-sm" style="margin: 0 auto;">Посмотреть больше...</a>
                                </div>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

        <input hidden value="{{$data['user']->hash_id}}" id="hash_id">
    </div>
@endsection




@push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script src="{{ asset('js') }}/PeriodDashboard/period.js"></script>
    <script>
        $(document).ready(function() {
          demo.initDashboardPageCharts();
        });
    </script>
@endpush
