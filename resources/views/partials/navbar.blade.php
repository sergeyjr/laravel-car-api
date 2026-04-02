@include('partials.header')

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ route('home') }}">My Application</a>

        <div>
            <a class="nav-link d-inline text-white" href="{{ route('about') }}">About</a>
            <a class="nav-link d-inline text-white" href="{{ route('contact') }}">Contact</a>
            <a class="nav-link d-inline text-white" href="{{ url('/cars') }}">Cars</a>
            <a class="nav-link d-inline text-white" href="{{ url('/dashboard') }}">Dashboard</a>

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
