@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>

    <p>Welcome, {{ auth()->user()->email }}</p>

    <p>This page is protected.</p>
@endsection
