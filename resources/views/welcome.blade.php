<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>КиноБронь</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


</head>
<body>
<div class="d-flex p-5 gap-5">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title"> Вход в админку</h1>

            <div>
                @if (Route::has('login'))
                    <div>
                        @auth
                            <a href="{{ url('/admin') }}">{{ __('Амин-панель') }}</a>
                        @else
                            <a href="{{ route('login') }}">{{ __('Войти') }}</a>
                            <br>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                            @endif
                        @endauth
                    </div>
                @endif

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Вход на главную страницу сайта</h1>

            <a class="btn btn-lg btn-primary" href="{{ route('public.pages.home') }}">{{ __('Перейти') }}</a>

        </div>
    </div>
</div>
</body>
</html>
