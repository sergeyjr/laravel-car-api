@extends('layouts.app')

@section('content')
    <h1>Login</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input class="form-control mb-2" name="email" placeholder="Email">
        <input class="form-control mb-2" type="password" name="password" placeholder="Password">

        <button class="btn btn-success">Login</button>
    </form>
@endsection
