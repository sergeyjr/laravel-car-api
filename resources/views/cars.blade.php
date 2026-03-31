@extends('layouts.app')

@section('content')
    <div id="app" v-cloak>

        <div v-if="loading" class="text-center my-5">
            <div class="spinner-border"></div>
        </div>

        <!-- DETAIL -->
        <div v-if="car">

            <h2>@{{ car.title }}</h2>

            <img
                :src="getImageUrl(car.photo_url)"
                style="max-width: 400px;"
            >

            <p class="mt-3"><strong>Price:</strong> @{{ car.price }}</p>
            <p><strong>Description:</strong> @{{ car.description }}</p>

            <button class="btn btn-secondary mb-3" @click="goBack">
                Back
            </button>

        </div>

        <!-- LIST -->
        <div v-else>

            <div class="row">
                <div v-for="car in cars" :key="car.id" class="col-4 mb-3">
                    <div class="card" style="cursor:pointer" @click="goToCar(car.id)">

                        <img
                            :src="getImageUrl(car.photo_url)"
                            class="card-img-top"
                            style="height: 200px; object-fit: cover;"
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

    </div>
@endsection

@push('scripts')
    <script>
        window.carId = @json($carId ?? null);
    </script>

    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="{{ asset('js/cars.js') }}"></script>
@endpush
