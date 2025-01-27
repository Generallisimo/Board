
<table class="table" id="await">
    <thead>
        <tr>
            <th>Exchange ID</th>
            <th>Market ID</th>
            <th>Фото подтверждения</th>
            <th>Сумма</th>
            <th>Метод оплаты</th>
            <th>Валюта</th>
            <th>Реквезиты обменника</th>
            <th>Статус платежа</th>
            <th>Процент Обменника</th>
            <th>Заработок Обменника</th>
            <th>Процент Куратора</th>
            <th>Заработок Куратора</th>
            <th>Процент Клиента</th>
            <th>Заработок Клиента</th>
            <th class="text-right">Действие</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($exchanges as $exchange)
        <tr>
            <td>{{$exchange->exchange_id}}</td>
            <td>{{$exchange->market_id}}</td>
            <td>
                <img src="{{ asset($exchange->photo) }}" alt="Фото подтверждения" style="max-width: 150px; max-height: 150px;">
            </td>
            <td>{{$exchange->amount_users}}</td>
            <td>{{$exchange->method}}</td>
            <td>{{$exchange->currency}}</td>
            <td>{{$exchange->details_market_payment}}</td>
            <td>{{$exchange->result}}</td>
            <td>{{$exchange->percent_market}}</td>
            <td>{{$exchange->amount_market}}</td>
            <td>{{$exchange->percent_agent}}</td>
            <td>{{$exchange->amount_agent}}</td>
            <td>{{$exchange->percent_client}}</td>
            <td>{{$exchange->amount_client}}</td>
            <td class="td-actions text-right">
                <form method="POST" action="{{route('transaction.update',['exchange_id'=> $exchange->exchange_id, 'status'=>'to_success', 'message'=>'Ожидания получения суммы'])}}">
                    @csrf
                    @method("PUT")
                    <button type="submit" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                        <i class="tim-icons icon-check-2"></i>
                    </button>
                </form>
                <form method="POST" action="{{route('transaction.update',['exchange_id'=> $exchange->exchange_id, 'status'=>'archive', 'message'=>'Архивировано, обратится в поддержку'])}}">
                    @csrf
                    @method("PUT")
                    <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                        <i class="tim-icons icon-trash-simple"></i>
                    </button>
                </form>
                <form method="POST" action="{{route('transaction.update',['exchange_id'=> $exchange->exchange_id, 'status'=>'dispute', 'message'=>'Отправлено на спор'])}}">
                    @csrf
                    @method("PUT")
                    <button type="submit" rel="tooltip" class="btn btn-warning btn-sm btn-icon">
                        <i class="tim-icons icon-chat-33"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
