@extends('layouts.app')

@section('content')

    <h1>Контактная форма</h1>

    <form method="POST" action="{{ route('contact.send') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">
                Имя <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                name="name"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">
                Email <span class="text-danger">*</span>
            </label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">
                Тема сообщения <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                class="form-control @error('subject') is-invalid @enderror"
                name="subject"
                value="{{ old('subject') }}"
                required
            >
        </div>

        {{-- Message --}}
        <div class="mb-3">
            <label class="form-label">
                Текст сообщения <span class="text-danger">*</span>
            </label>
            <textarea
                class="form-control @error('body') is-invalid @enderror"
                name="body"
                rows="4"
                required
            >{{ old('body') }}</textarea>
        </div>

        <button class="btn btn-primary">Отправить</button>
    </form>

@endsection
