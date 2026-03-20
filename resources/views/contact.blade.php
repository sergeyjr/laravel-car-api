@extends('layouts.app')

@section('content')
    <h1>Contact</h1>

    <form method="POST" action="{{ route('contact.send') }}">
        @csrf

        <input class="form-control mb-2" name="name" placeholder="Name">
        <input class="form-control mb-2" name="email" placeholder="Email">
        <input class="form-control mb-2" name="subject" placeholder="Subject">
        <textarea class="form-control mb-2" name="body" placeholder="Message"></textarea>

        <button class="btn btn-primary">Send</button>
    </form>
@endsection
