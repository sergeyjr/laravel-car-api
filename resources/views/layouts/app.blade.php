<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My Application')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @stack('meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="@yield('body-class')">

@include('partials.navbar')

<main class="container mt-4">
    @include('partials.alerts')
    <div id="alert-container"></div>
    @yield('content')
</main>

@include('partials.footer')

@stack('scripts')

</body>
</html>
