@extends('layouts.app')

@section('content')
    <h1>Home</h1>

    @auth
        <p>You are logged in</p>
    @else
        <p>You are guest</p>
    @endauth

@endsection
