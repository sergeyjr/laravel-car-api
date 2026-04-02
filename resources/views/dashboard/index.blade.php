@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">

        <h1 class="mb-3">Панель управления</h1>

        <p class="mb-4">
            Добро пожаловать, {{ auth()->user()->email }}
        </p>

        <div class="mb-4 d-flex gap-2 flex-wrap">

            <a href="{{ url('/cars/create') }}" class="btn btn-primary">
                Добавить авто
            </a>

            <a href="{{ url('/dashboard/profile') }}" class="btn btn-outline-secondary">
                Профиль
            </a>

        </div>

        <div class="row">

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Мой профиль</h5>
                        <p class="mb-0">{{ auth()->user()->name ?? 'User' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Статус</h5>
                        <p class="mb-0 text-success">Active</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
