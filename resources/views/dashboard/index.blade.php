@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">

        <h1>Dashboard</h1>

        <p>Welcome, {{ auth()->user()->email }}</p>

        <a href="{{ url('/cars/create') }}" class="btn btn-primary">
            Create Car
        </a>

    </div>
@endsection
