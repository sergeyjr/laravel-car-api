@extends('layouts.app')

@section('content')

    <h1>Contact</h1>

    <form method="POST" action="{{ route('contact.send') }}">
        @csrf

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label">
                Name <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                name="name"
                value="{{ old('name') }}"
                required
            >
        </div>

        {{-- Email --}}
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

        {{-- Subject --}}
        <div class="mb-3">
            <label class="form-label">
                Subject <span class="text-danger">*</span>
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
                Message <span class="text-danger">*</span>
            </label>
            <textarea
                class="form-control @error('body') is-invalid @enderror"
                name="body"
                rows="4"
                required
            >{{ old('body') }}</textarea>
        </div>

        <button class="btn btn-primary">Send</button>
    </form>

@endsection
