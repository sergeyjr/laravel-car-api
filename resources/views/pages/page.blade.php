@extends('layouts.app')

@section('content')

    <h1 class="mb-3">{{ $page->title }}</h1>

    <div class="row">
        <div class="col-12">
            {!! nl2br(e($page->content)) !!}
        </div>
    </div>

@endsection
