@extends('layouts.app')

@section('content')

    <h1>Контактная форма</h1>

    <form method="POST" action="{{ route('contact.send') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="contact-name">
                Имя <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                name="name"
                id="contact-name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                required
            >
            @error('name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="contact-email">
                Email <span class="text-danger">*</span>
            </label>
            <input
                type="email"
                name="email"
                id="contact-email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                required
            >
            @error('email')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="contact-subject">
                Тема сообщения <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                name="subject"
                id="contact-subject"
                class="form-control @error('subject') is-invalid @enderror"
                value="{{ old('subject') }}"
                required
            >
            @error('subject')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="contact-body">
                Текст сообщения <span class="text-danger">*</span>
            </label>
            <textarea
                name="body"
                id="contact-body"
                rows="4"
                class="form-control @error('body') is-invalid @enderror"
                required
            >{{ old('body') }}</textarea>

            @error('body')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Отправить
        </button>

    </form>

@endsection
