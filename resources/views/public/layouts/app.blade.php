<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('КиноБронь') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Scripts -->

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    @vite(['resources/sass/public/app.scss', 'resources/js/public/app.js'])
</head>
<body>
<div id="app">
    @if(strpos(request()->path(), 'afisha/') !== 0)
        @include('public.partials.header')
    @endif

    @yield('content')

    @if(strpos(request()->path(), 'afisha/') !== 0)
        @include('public.partials.footer')
    @endif

</div>
</body>
</html>
