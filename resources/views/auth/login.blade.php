@extends('layouts.app')

@section('content')

    <h1>Авторизация</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="login-email">
                Email <span class="text-danger">*</span>
            </label>
            <input
                type="email"
                name="email"
                id="login-email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                required
            >
            @error('email')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="login-password">
                Пароль <span class="text-danger">*</span>
            </label>
            <input
                type="password"
                name="password"
                id="login-password"
                class="form-control @error('password') is-invalid @enderror"
                required
            >
            @error('password')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            Войти
        </button>

        <p><a href="/register">Зарегистрироваться</a></p>

    </form>

@endsection
