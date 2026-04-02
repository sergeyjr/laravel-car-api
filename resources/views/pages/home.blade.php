@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Главная страница</h1>
            <p class="text-muted">Простой Laravel проект</p>
        </div>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h4 class="card-title">Статус пользователя</h4>

                        @auth
                            <p class="text-success mb-0">Вы авторизованы</p>
                            <small class="text-muted">Добро пожаловать обратно!</small>
                        @else
                            <p class="text-warning mb-0">Вы гость</p>
                            <small class="text-muted">Войдите, чтобы получить доступ ко всем функциям</small>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h4 class="card-title">Быстрые действия</h4>

                        @auth
                            <a href="/profile" class="btn btn-primary w-100 mb-2">Профиль</a>
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    Выйти
                                </button>
                            </form>
                        @else
                            <a href="/login" class="btn btn-primary w-100 mb-2">Войти</a>
                            <a href="/register" class="btn btn-outline-secondary w-100">Регистрация</a>
                        @endauth

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
