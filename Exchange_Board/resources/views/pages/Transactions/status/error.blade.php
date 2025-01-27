

<table class="table" id="error" style="display: none;">
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
        </tr>
    </thead>
    <tbody>
        @foreach ($exchangesError as $exchange)
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
        </tr>
        @endforeach
    </tbody>
</table>
