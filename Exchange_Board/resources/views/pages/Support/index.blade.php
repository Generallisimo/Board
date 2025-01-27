@extends('layouts.app', ['page' => __('Поддержка'), 'pageSlug' => 'support'])

@section('content')
    <div class="container mt-4">
                @if (session('successful'))
                    <div class="alert alert-success">
                        {{ session('successful') }}
                    </div>
                @endif
                @if ($errors->has('destroy_chat'))
                    <div class="alert alert-danger">
                        {{ $errors->first('destroy_chat') }}
                    </div>
                @endif
        <!-- Фильтрация чатов -->
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h2>Чаты поддержки</h2>

            <form id="supportForm" method="GET" class="d-flex">
                <input type="text" name="chat_id" placeholder="Введите ID пользователя" id="chat_id_input" class="form-control" style="margin-top: 2px; background-color: #242340;">
                <button type="submit" class="btn btn-primary btn-sm" style="margin-left: 4px; overflow:visible">Перейти</button>
            </form>


            <!-- Кнопки для фильтрации -->
            <div class="btn-group" role="group" aria-label="Фильтр чатов">
                <button id="all_but" class="btn btn-secondary">Все</button>
                <button id="read_but" class="btn btn-success">Прочитанные</button>
                <button id="unread_but" class="btn btn-warning">Непрочитанные</button>
            </div>
        </div>

        <!-- Список чатов -->
        <div id="chatList">
            @if(!$data->isEmpty())
                <div class="list-group">
                    @foreach($data as $item)
                        @php
                            $statusClass = (int) $item->status === 0 ? 'read' : 'unread';
                        @endphp

                        <div class="list-group-item justify-content-between align-items-center chat-item {{ $statusClass }}" style="background-color: #27293d; border: #27293d; display:flex">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Кружок статуса -->
                                <span class="status-circle {{ $statusClass === 'read' ? 'bg-success' : 'bg-warning' }}"></span>
                                <div class="ml-2">
                                    <h5 class="mb-1">ID: {{$item->chat_id}}</h5>
                                    <p class="mb-1">{{$item->name}}</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <form method="GET" action="{{ route('support.show', ['chat_id'=>$item->chat_id]) }}">
                                    <button class="btn btn-primary btn-sm btn-icon" style="color: white;">
                                        <i class="tim-icons icon-send"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('chat.destroy', ['chat_id'=>$item->chat_id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                        <i class="tim-icons icon-trash-simple"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info mt-3" role="alert">
                    Сообщений пока нет.
                </div>
            @endif
        </div>
    </div>
@endsection

<style>
    .bg-success {
        background-color: #28a745 !important;
    }
    .bg-warning {
        background-color: #ffc107 !important;
    }
    .status-circle {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .chat-item {
        display: table; /* Это гарантирует, что элементы будут отображаться */
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const allBut = document.getElementById('all_but');
    const readBut = document.getElementById('read_but');
    const unreadBut = document.getElementById('unread_but');
    const chatItems = document.querySelectorAll('.chat-item');

    // Функция показа всех чатов
    allBut.addEventListener('click', function() {
        chatItems.forEach(item => {
            item.style.display = 'flex';
        });
    });

    // Функция показа только прочитанных чатов
    readBut.addEventListener('click', function() {
        chatItems.forEach(item => {
            if (item.classList.contains('read')) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Функция показа только непрочитанных чатов
    unreadBut.addEventListener('click', function() {
        chatItems.forEach(item => {
            if (item.classList.contains('unread')) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    document.getElementById('supportForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Останавливаем стандартную отправку формы
        var chat_id = document.getElementById('chat_id_input').value;
        if (chat_id) {
            var actionUrl = "{{ url('support/show') }}/" + chat_id;
            window.location.href = actionUrl; // Перенаправляем на динамический URL
        }
    });
});
</script>
