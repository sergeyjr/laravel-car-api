@extends('layouts.app')

@section('content')

    <h1>Login</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">
                Email <span class="text-danger">*</span>
            </label>
            <input
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                required
            >
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="form-label">
                Password <span class="text-danger">*</span>
            </label>
            <input
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Login
        </button>
    </form>
@endsection
