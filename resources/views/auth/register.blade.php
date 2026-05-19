@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <h1 class="mb-4">Регистрация</h1>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="register-name">
                            Имя <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="register-name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="register-email">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="register-email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="register-password">
                            Пароль <span class="text-danger">*</span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="register-password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                        >
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="register-password-confirmation">
                            Повтор пароля <span class="text-danger">*</span>
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="register-password-confirmation"
                            class="form-control"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Зарегистрироваться
                    </button>

                    <p class="text-center mt-3">
                        <a href="/login">Войти</a>
                    </p>

                </form>

            </div>
        </div>
    </div>

@endsection
