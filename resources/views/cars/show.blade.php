@extends('layouts.app')

@section('content')
    <div id="app">

        <div v-if="car">

            <h2>{{ $car->title }}</h2>

            <img
                src="{{ $car->photo_url ? '/files/'.$car->photo_url : '/images/cars/default.jpg' }}"
                style="max-width: 400px;"
            >

            <p class="mt-3"><strong>Price:</strong> {{ $car->price }}</p>
            <p><strong>Description:</strong> {{ $car->description }}</p>

            @if($car->option)
                <p><strong>Brand:</strong> {{ $car->option->brand }}</p>
                <p><strong>Model:</strong> {{ $car->option->model }}</p>
                <p><strong>Year:</strong> {{ $car->option->year }}</p>
                <p><strong>Mileage:</strong> {{ $car->option->mileage }}</p>
            @endif

            <button class="btn btn-secondary mb-3" onclick="window.location.href='/cars'">
                Back
            </button>

        </div>

    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cars.css') }}">
@endpush
