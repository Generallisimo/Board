<!DOCTYPE html>
<html lang="en" style="color-scheme: light;" class="light">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=500px, initial-scale=1">

    <meta name="viewport"
        content="width=device-width,initial-scale=1.0,viewport-fit=cover,maximum-scale=1,user-scalable=0">
    <link rel="stylesheet" href="{{asset('payment_files')}}/42e37e64fa7cfbdd.css" data-precedence="next">
    <link rel="stylesheet" href="{{asset('payment_files')}}/bdfefdafe762e748.css" data-precedence="next">
    <link rel="stylesheet" href="{{asset('payment_files')}}/5a56e3c1761e58ad.css" data-precedence="next">
    <meta name="theme-color" content="black">
    <title>Оплата</title>
    <meta name="description" content="Оплата">
    <link rel="icon" href="{{asset('payment_files')}}/favicon.ico" type="image/x-icon" sizes="16x16">
    <link rel="preload" href="{{asset('payment_files')}}/26a46d62cd723877-s.p.woff2" as="font" crossorigin="" type="font/woff2">
    <link rel="preload" href="{{asset('payment_files')}}/a34f9d1faa5f3315-s.p.woff2" as="font" crossorigin="" type="font/woff2">

</head>

<body class="__className_5b2c46">

    {{-- <script>
        function setCookie(name, value, hours) {
            const date = new Date();
            date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
            const expires = "expires=" + date.toUTCString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/";
        }

        function getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function startTimer(duration) {
            let remainingTime = duration;
            const timerElement = document.getElementById('timer');

            const interval = setInterval(function() {
                const minutes = Math.floor(remainingTime / 60);
                const seconds = remainingTime % 60;
                timerElement.textContent =
                    `${String(minutes).padStart(2, '0')} : ${String(seconds).padStart(2, '0')}`;

                if (remainingTime <= 0) {
                    clearInterval(interval);
                    timerElement.textContent = "Время вышло!";
                }

                remainingTime--;
                setCookie("remainingTime", remainingTime, 1 / 24); // сохраняем оставшееся время в cookie на 1 час
            }, 1000);
        }

        function initializeTimer() {
            let remainingTime = getCookie("remainingTime");

            if (remainingTime) {
                remainingTime = parseInt(remainingTime);
            } else {
                remainingTime = 30 * 60; // 30 минут в секундах
            }

            startTimer(remainingTime);
        }

        window.onload = initializeTimer;
    </script> --}}

 

@yield('content')

</body>

</html>
