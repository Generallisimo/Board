@extends('layouts.exchange.app')


@section('content')
    <main class="flex min-h-screen flex-col items-center justify-between p-3">
        <div class="flex justify-center py-10" style="opacity: 1; transform: none;">
            <div class="Toastify"></div>
            <div class="rounded-xl border bg-card text-card-foreground shadow max-w-[calc(100vw-46px)] w-[500px]">
                <div class="flex flex-col space-y-1.5 p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold leading-none tracking-tight">
                            <div class="flex items-center">
                                <div class="mr-1 mt-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                        </path>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg></div>
                                <h3 class="text-xl font-semibold text-blue-500">Пополнение</h3>
                            </div>
                        </h3>
                        <p class="text-sm text-muted-foreground"><span
                                class="text-sm cursor-pointer opacity-60 text-gray-500">{{$result['payment_date']}}</span></p>
                    </div> 
                    <p class="text-sm text-muted-foreground"><span
                            class="text-sm cursor-pointer opacity-60 transition-opacity hover:opacity-100 text-gray-500 hover:text-blue-500">Счет: {{$result['exchange_id']}}</span></p>
                </div>
                <div class="p-6 pt-0">
                    <!--- окошко зеленое --->
                    <div
                        class="flex items-center justify-between text-white p-4 rounded-lg mb-4 pattern-wavy pattern-opacity-100 pattern-size-16 pattern-green-500 pattern-bg-green-600">
                        <div
                            class="hidden pattern-green-500 pattern-bg-green-600 pattern-green-500 pattern-bg-green-600 pattern-blue-500 pattern-bg-blue-600 pattern-gray-500 pattern-bg-gray-600">
                        </div>
                        <div class="flex items-center">
                            <div class="ml-3">
                                <div class="flex justify-start">
                                    <div class="mr-1 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                            height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-shield-check">
                                            <path
                                                d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                            </path>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg></div>

                                    <p class="font-semibold">PINCASH</p>
                                </div>
                                @if($result['currency'] === 'RUB')
                                    <p class="mt-3 text-2xl text-white font-semibold">{{$result['amount_users']}} ₽</p>
                                @elseif($result['currency'] === 'UAH')
                                    <p class="mt-3 text-2xl text-white font-semibold">{{$result['amount_users']}} ₴</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="flex justify-end"><svg xmlns="http://www.w3.org/2000/svg" width="25"
                                    height="25" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock mr-1 mt-0.5">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>

                                <span class="font-semibold ml-1 text-2xl text-white" id="timer">{{ $result['remainingTime'] }}
                                </span>
                            </p>
                            <p class="mt-3 text-sm text-gray-200">Время на оплату </p>
                        </div>
                    </div>
                    <!--- окошко зеленое end --->
                    <div class="flex flex-col my-4">
                        <div class="container mx-auto p-0">
                            <div
                                class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-blue-500 rounded-lg">
                                <label for="f1ileInput" class="cursor-pointer">
                                    <div
                                        class="flex flex-col items-center justify-center w-96 h-32 p-4 text-center rounded-lg">
                                        <input type="text" id="walletMarketInput" value="{{$result['wallet_market']}}" readonly hidden>


                                        <button onclick="copyText()"
                                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors
     focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 py-2 mt-4 px-6 !bg-transparent">
                                            <div class="flex justify-between"><span class="px-2">
                                                    <p class="mt-5 text-2xl text-black font-semibold">{{$result['wallet_market']}}
                                                    </p>
                                                    <p class="mt-4 text-1xl text-black">Нажмите что бы скопировать</p>
                                                </span></div>
                                        </button>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="my-4">
                        <div class="flex justify-between mb-2 border-2 border-destructive rounded-lg p-6">
                            <div class="flex flex-col w-10/12">
                                <p class="text-sm mt-2 text-gray-600">Переводите точную сумму одним переводом! <br>
                                    Реквизиты оплаты меняются каждый платеж! <br>
                                    Если возник вопрос, задайте его в нашем чате.
                                </p>
                                <p></p>
                            </div>
                            <div class="w-1/7 flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-circle-alert h-14 w-14 text-destructive">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" x2="12" y1="8" y2="12"></line>
                                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="flex items-center p-6 pt-0">
                    <div class="flex justify-between w-full">
                        <button onclick="closePage()"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">Вернуться
                            на сайт
                        </button>
                            <button onclick="redirectToSupport()"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
                            <div class="flex justify-between">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                    height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-help #6b7280">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                    <path d="M12 17h.01"></path>
                                </svg>
                                <span class="ml-2">Поддержка</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        window.apiUrl = "{{ config('app.api_local') }}";

        let remainingTime = {{ $result['remainingTime'] }}; 
        let exchange_id = "{{ $result['exchange_id'] }}"; 
        const url = window.apiUrl;
        const checkStatusUrl = `${url}/api/payment/status/${exchange_id}`;
        const redirectUrl = `${url}/api/payment/update/${exchange_id}`;
        const archiveUrl = "{{ route('transaction.update', ['exchange_id' => $result['exchange_id'], 'status' => 'archive', 'message' => 'Время на оплату истекло']) }}";

        console.log("Redirecting to:", redirectUrl);


        // ====== Функция отправки запроса на архивирование ======
        async function archiveTransaction() {
            try {
                const response = await fetch(archiveUrl, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                });

                if (!response.ok) {
                    console.error("Ошибка при архивировании:", response.status);
                    return;
                }

                const data = await response.json();
                console.log("Транзакция заархивирована:", data);
            } catch (error) {
                console.error("Ошибка сети при архивировании:", error);
            }
        }

        // ====== Функция обратного отсчёта времени ======
        function startTimer() {
            const timerElement = document.getElementById('timer');

            if (!timerElement) {
                console.error("Элемент #timer не найден!");
                return;
            }

            console.log("Таймер запущен. Начальное значение:", remainingTime);

            const interval = setInterval(() => {
                if (remainingTime <= 0) {
                    clearInterval(interval);
                    console.log("Время истекло! Архивируем и редиректим...");
                    archiveTransaction();
                    window.location.replace(redirectUrl);
                    return;
                }

                const minutes = Math.floor(remainingTime / 60);
                const seconds = remainingTime % 60;
                timerElement.textContent = `${String(minutes).padStart(2, '0')} : ${String(seconds).padStart(2, '0')}`;

                remainingTime--;
            }, 1000);

            // Запускаем архивирование, когда оставшееся время истечёт
            setTimeout(() => {
                console.log("Время вышло! Архивируем сделку...");
                archiveTransaction();
            }, remainingTime * 1000); // Ориентируемся на `remainingTime` с сервера
        }

        // ====== Функция проверки статуса сделки ======
        async function checkExchangeStatus() {
            try {
                const response = await fetch(checkStatusUrl, {
                    method: "GET",
                    headers: {
                        "Accept": "application/json"
                    }
                });

                if (!response.ok) {
                    console.error("Ошибка при запросе статуса:", response.status);
                    return;
                }

                const data = await response.json();
                console.log("Текущий статус сделки:", data.status);

                // Если статус НЕ "await" -> редирект
                if (data.status !== "await") {
                    console.log("Статус изменён, редирект на:", redirectUrl);
                    window.location.replace(redirectUrl);
                }
            } catch (error) {
                console.error("Ошибка при проверке статуса:", error);
            }
        }

        // Запуск таймера
        startTimer();

        // Запуск проверки статуса сделки каждую минуту
        setInterval(checkExchangeStatus, 10000);

        // Первый запрос сразу (не ждем 1 минуту)
        checkExchangeStatus();

    </script>

    <script>
        // function copyText() {
        //     navigator.clipboard.writeText({{$result['wallet_market']}});
        // }
        function copyText() {
            let inputElement = document.getElementById("walletMarketInput");
            let textToCopy = inputElement.value; // Получаем значение

            console.log("Копируемый текст:", textToCopy);

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(textToCopy)
            } else {
                fallbackCopyText(inputElement);
            }
        }

        function fallbackCopyText(inputElement) {
            inputElement.removeAttribute("hidden"); // Временно делаем input видимым
            inputElement.select(); // Выделяем текст
            document.execCommand("copy"); // Копируем
            inputElement.setAttribute("hidden", ""); // Скрываем обратно
        }

        function redirectToSupport() {
            window.location.href = "{{ route('support.show', ['chat_id' => $result['exchange_id']]) }}";
        }

        function closePage() {
            if (window.history.length > 1) {
                window.history.back(); // Возвращает на предыдущую страницу
            } else {
                window.close(); // Пытаемся закрыть страницу
                window.location.href = "/"; // Если не закрылось – редирект на главную
            }
        }
    </script>
@endsection
