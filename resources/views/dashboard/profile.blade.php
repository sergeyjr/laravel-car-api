@extends('layouts.app')

@section('content')

    <div class="row">

        {{-- LEFT: PROFILE CARD --}}
        <div class="col-md-4">

            <div class="card mb-3">
                <div class="card-body text-center">

                    {{-- AVATAR --}}
                    @if(auth()->user()->avatar)
                        <img src="/storage/{{ auth()->user()->avatar }}"
                             class="rounded-circle mb-3"
                             width="120" height="120">
                    @else
                        <img src="/images/default-avatar.png"
                             class="rounded-circle mb-3"
                             width="120" height="120">
                    @endif

                    <h4>{{ auth()->user()->name }}</h4>
                    <p class="text-muted">{{ auth()->user()->email }}</p>

                    <small class="text-muted">
                        Создан: {{ auth()->user()->created_at }}
                    </small>

                </div>
            </div>

            {{-- ACCOUNT ACTIONS --}}
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('profile.delete') }}">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger w-100"
                                onclick="return confirm('Удалить аккаунт?')">
                            Удалить аккаунт
                        </button>
                    </form>

                </div>
            </div>

        </div>

        {{-- RIGHT: FORMS --}}
        <div class="col-md-8">

            {{-- PROFILE UPDATE --}}
            <div class="card mb-3">
                <div class="card-header">
                    Редактирование профиля
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label>Имя</label>
                            <input class="form-control" name="name"
                                   value="{{ auth()->user()->name }}">
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input class="form-control" name="email"
                                   value="{{ auth()->user()->email }}">
                        </div>

                        <div class="mb-3">
                            <label>Аватар</label>
                            <input type="file" class="form-control" name="avatar">
                        </div>

                        <button class="btn btn-primary">
                            Сохранить
                        </button>

                    </form>

                </div>
            </div>

            {{-- PASSWORD CHANGE --}}
            <div class="card">

                <div class="card-header">
                    Смена пароля
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf

                        <div class="mb-3">
                            <input type="password"
                                   class="form-control"
                                   name="current_password"
                                   placeholder="Текущий пароль">
                        </div>

                        <div class="mb-3">
                            <input type="password"
                                   class="form-control"
                                   name="password"
                                   placeholder="Новый пароль">
                        </div>

                        <div class="mb-3">
                            <input type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   placeholder="Подтверждение пароля">
                        </div>

                        <button class="btn btn-warning">
                            Обновить пароль
                        </button>

                    </form>

                </div>
            </div>

        </div>

    </div>

@endsection
