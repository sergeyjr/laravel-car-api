@include('partials.header')

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ route('home') }}">Тестовое приложение</a>

        <div class="nav-divider d-flex align-items-center">

            <a class="nav-link d-inline text-white" href="{{ url('/cars') }}">Каталог</a>
            <span class="text-white mx-2">|</span>

            <a class="nav-link d-inline text-white" href="{{ route('contact') }}">Контакты</a>
            <span class="text-white mx-2">|</span>

            <a class="nav-link d-inline text-white" href="{{ route('about') }}">О нас</a>
            <span class="text-white mx-2">|</span>

            <a class="nav-link d-inline text-white" href="{{ url('/dashboard') }}">Личный кабинет</a>

            @auth
                <span class="text-white mx-2">|</span>

                <a href="{{ route('logout') }}"
                   class="nav-link d-inline text-white"
                   onclick="event.preventDefault();
                   if (confirm('Вы уверены, что хотите выйти?')) {
                       document.getElementById('logout-form').submit();
                   }">
                    Выход
                </a>

                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                    @csrf
                </form>
            @else
                <span class="text-white mx-2">|</span>
                <a class="nav-link d-inline text-white" href="{{ route('login') }}">Вход</a>
            @endauth

        </div>

    </div>
</nav>
