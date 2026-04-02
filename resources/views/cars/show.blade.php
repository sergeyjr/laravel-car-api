@extends('layouts.app')

@section('content')

    <h2 class="mb-4">{{ $car->title }}</h2>

    <div class="row">

        {{-- IMAGE --}}
        <div class="col-md-5">
            <img
                src="{{ $car->photo_url ? '/files/'.$car->photo_url : '/images/cars/default.jpg' }}"
                class="img-fluid rounded"
                style="max-height: 400px; object-fit: cover;"
            >
        </div>

        {{-- INFO --}}
        <div class="col-md-7">

            <p><strong>Цена:</strong> {{ $car->price }}</p>
            <p><strong>Описание:</strong> {{ $car->description }}</p>

            @if($car->option)
                <p><strong>Бренд:</strong> {{ $car->option->brand }}</p>
                <p><strong>Модель:</strong> {{ $car->option->model }}</p>
                <p><strong>Год:</strong> {{ $car->option->year }}</p>
                <p><strong>Пробег:</strong> {{ $car->option->mileage }}</p>
            @endif

        </div>

    </div>

    <hr>

    <button class="btn btn-secondary mt-3"
            onclick="window.location.href='/cars'">
        Назад
    </button>

@endsection

