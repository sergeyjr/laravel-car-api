@extends('layouts.app')

@section('content')

    <h1>About</h1>

    <div class="card">
        <div class="card-body">
            <pre style="white-space: pre-wrap;">{{ $content }}</pre>
        </div>
    </div>

@endsection
