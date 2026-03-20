@extends('layouts.app')

@section('content')
    <h1>Login</h1>

    @if($errors->any())
        <div style="color:red;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input name="email" value="{{ old('email') }}" placeholder="Email">
        <br><br>

        <input type="password" name="password" placeholder="Password">
        <br><br>

        <button type="submit">Login</button>
    </form>
@endsection
