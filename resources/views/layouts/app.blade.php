<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">My Application</a>

        <div>
            <a class="nav-link d-inline text-white" href="{{ route('home') }}">Home</a>
            <a class="nav-link d-inline text-white" href="{{ route('about') }}">About</a>
            <a class="nav-link d-inline text-white" href="{{ route('contact') }}">Contact</a>
            <a class="nav-link d-inline text-white" href="{{ url('/cars') }}">Cars</a>

            @auth
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-link text-white">Logout</button>
                </form>
            @else
                <a class="nav-link d-inline text-white" href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>

@stack('scripts')

</body>
</html>
