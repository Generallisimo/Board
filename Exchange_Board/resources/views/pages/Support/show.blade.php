@extends('layouts.support.app')

@section('content')
<link rel="stylesheet"  href="{{ asset('css/messages.css') }}">
<div class="container text-center mt-3">
    <h2>Чат с {{$chat->name}} - {{$chat->chat_id}}</h2>
</div>
<div class="container mt-5">
    <div id="chat-container">
        <ul id="messages-list" class="list-unstyled">
            @foreach($messages as $item)
                <p class="message-name {{ $item->send_id === $user_id ? 'sent' : 'received' }}">{{$item->name}}</p>
                <li class="message {{ $item->send_id === $user_id ? 'sent' : 'received' }}">
                    {{ $item->messages }}
                </li>
                
            @endforeach
        </ul>
    </div>
</div>

<!-- Форма для отправки сообщений -->
<div id="message-form" class="container">
    <form id="message-form">
        @csrf
        <div class="input-group">
            <input type="text" name="message" id="message-input" class="form-control" placeholder="Type your message">
            <input type="hidden" id="chat_id" value="{{ $chat->chat_id }}">
            <input type="hidden" id="user_id" value="{{ $user_id }}">
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
</div>

<script>
    window.apiUrl = "{{ config('app.api_local') }}";
</script>
<script src="{{ asset('js') }}/Message/message.js"></script>

@endsection
