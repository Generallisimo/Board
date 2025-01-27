@extends('layouts.app', ['page' => __('Все пользователи'), 'pageSlug' => 'all users'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if (session('successful'))
                    <div class="alert alert-success">
                        {{ session('successful') }}
                    </div>
                @endif
                @if ($errors->has('destroy_user'))
                    <div class="alert alert-danger">
                        {{ $errors->first('destroy_user') }}
                    </div>
                @endif
                <!-- <h5 class="title">All Users</h5> -->
                <div class="text-right">
                    <button id="markets_but" type="button" class="btn btn-default">Обменники</button>
                    @if(Auth::user()->hasRole('admin'))
                    <button id="clients_but" type="button" class="btn btn-default">Клиенты</button>
                    <button id="agents_but" type="button" class="btn btn-default">Кураторы</button> 
                    <button id="supports_but" type="button" class="btn btn-default">Поддержка</button> 
                    @endif
                </div>
            </div>
            <div class="table-responsive">
            <table class="table" id="clients" style="display: none;">
                <thead>
                    <tr>
                        <th>Hash_id</th>
                        <th>Процент</th>
                        <th>Реквезиты пополнения</th>
                        <th>Реквезиты вывода</th>
                        <th>Баланс</th>
                        <th>API ключ</th>
                        <th>API ссылка</th>
                        <th>Мошенников</th>
                        <th class="text-right">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['clients'] as $client)
                    <tr>
                        <td>{{$client->hash_id}}</td>
                        <td>{{$client->percent}} %</td>
                        <td>{{$client->details_from}}</td>
                        
                        <td>{{$client->details_to}}</td>
                        <td>{{$client->balance}}</td>
                        
                        <td>{{config('url.api_local')}}/api/pay/{currency}/{amount}/{{$client->api_key}}</td>
                        <td>{{config('url.api_local')}}/api/payment/{{$client->api_link}}/{amount}/{currency}</td>
                        @if($client->fraud === null)
                        <td>0</td>
                        @else
                        <td>{{$client->fraud}}</td>
                        @endif
                        <td class="td-actions text-right">
                            <form method="GET" action="{{ route('table.user.edit', ['hash_id'=>$client->hash_id]) }}">
                                @csrf
                                <button type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                                    <i class="tim-icons icon-settings"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('table.user.destroy', ['hash_id'=>$client->hash_id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table" id="agents" style="display: none;">
                <thead>
                    <tr>
                        <th>Hash_id</th>
                        <th>Процент</th>
                        <th>Реквезиты пополнения</th>
                        <th>Реквезиты вывода</th>
                        <th>Баланс</th>
                        <th class="text-right">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['agents'] as $agent)
                    <tr>
                        <td>{{$agent->hash_id}}</td>
                        <td>{{$agent->percent}} %</td>
                        <td>{{$agent->details_from}}</td>
                        
                        <td>{{$agent->details_to}}</td>
                        <td>{{$agent->balance}}</td>
                        <td class="td-actions text-right">
                            <form method="GET" action="{{ route('table.user.edit', ['hash_id'=>$agent->hash_id]) }}">
                                @csrf
                                <button type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                                    <i class="tim-icons icon-settings"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('table.user.destroy', ['hash_id'=>$agent->hash_id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table" id="supports" style="display: none;">
                <thead>
                    <tr>
                        <th>Hash_id</th>
                        <th class="text-right">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['supports'] as $agent)
                    <tr>
                        <td>{{$agent->hash_id}}</td>
                        <td class="td-actions text-right">
                            <form method="POST" action="{{ route('table.user.destroy', ['hash_id'=>$agent->hash_id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table" id="markets">
                <thead>
                    <tr>
                        <th>Hash_id</th>
                        <th>Статус</th>
                        <th>Процент</th>
                        <th>Реквезиты пополнения</th>
                        <th>Реквезиты вывода</th>
                        <th>Баланс</th>
                        <th>Кошелек</th>
                        <th class="text-right">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['markets'] as $market)
                    <tr>
                        <td>{{$market->hash_id}}</td>
                        <td>{{$market->status}}</td>
                        <td>{{$market->percent}} %</td>
                        <td>{{$market->details_from}}</td>
                        
                        <td>{{$market->details_to}}</td>
                        <td>{{$market->balance}}</td>
                        <td class="td-actions text-right">
                            <form method="GET" action="{{route('table.user.market.show', ['hash_id'=>$market->hash_id])}}">
                                @csrf
                                <button type="submit" rel="tooltip" class="btn btn-info btn-sm btn-icon">
                                    <i class="tim-icons icon-single-02"></i>
                                </button>
                            </form>
                        </td>
                        <td class="td-actions text-right">
                            <form method="GET" action="{{ route('table.user.edit',['hash_id'=>$market->hash_id]) }}">
                                @csrf
                                <button type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                                    <i class="tim-icons icon-settings"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('table.user.destroy', ['hash_id'=>$market->hash_id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>



<script src="{{ asset('js') }}/users/SelectTableIndex.js"></script>
@endsection