@extends('layouts.app')

@section('content')
    <div id="app">
        <div v-if="loading">Loading...</div>

        <div class="row">
            <div v-for="car in cars" :key="car.id" class="col-4 mb-3">
                <div class="card">

                    <img
                        :src="getImageUrl(car.photo_url)"
                        class="card-img-top"
                        style="height: 200px; object-fit: cover;"
                        alt=""
                    >

                    <div class="card-body">
                        <h5>@{{ car.title }}</h5>
                        <p>@{{ car.price }}</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button @click="prevPage" :disabled="page <= 1">Prev</button>
            <button @click="nextPage">Next</button>
        </div>

        <div class="mt-2">
            Page: @{{ page }} / @{{ Math.ceil(total / perPage) }}
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="{{ asset('js/cars.js') }}"></script>
@endpush
