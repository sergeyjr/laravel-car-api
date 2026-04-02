@extends('layouts.app')

@section('content')

    <h1>Cars</h1>

    <div class="row">
        @foreach($cars as $car)
            <div class="col-4 mb-3">
                <div class="card" style="cursor:pointer"
                     onclick="window.location.href='/cars/show/{{ $car->id }}'">

                    <img
                        src="{{ $car->photo_url ? '/files/'.$car->photo_url : '/images/cars/default.jpg' }}"
                        class="card-img-top"
                        style="height:200px; object-fit:cover;"
                    >

                    <div class="card-body">
                        <h5>{{ $car->title }}</h5>
                        <p>{{ $car->price }}</p>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex gap-2 mt-3">
        @if($cars->onFirstPage())
            <button disabled>Назад</button>
        @else
            <a href="{{ $cars->previousPageUrl() }}">
                <button>Назад</button>
            </a>
        @endif

        @if($cars->hasMorePages())
            <a href="{{ $cars->nextPageUrl() }}">
                <button>Вперёд</button>
            </a>
        @else
            <button disabled>Вперёд</button>
        @endif
    </div>

    <div class="mt-2">
        Страница: {{ $cars->currentPage() }} / {{ $cars->lastPage() }}
        <br>
        Показано {{ $cars->firstItem() }}–{{ $cars->lastItem() }}
        из {{ $cars->total() }} автомобилей
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cars.css') }}">
@endpush
