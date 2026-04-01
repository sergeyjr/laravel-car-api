<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Application')</title>
    @stack('meta')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    @stack('styles')
</head>
<body>

@include('partials.header')

@include('partials.navbar')

<div class="container mt-4">
    @include('partials.alerts')
    @yield('content')
</div>

@include('partials.footer')

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

@stack('scripts')

</body>
</html>
