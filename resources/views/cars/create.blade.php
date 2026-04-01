@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h1>Create Car</h1>

                <div class="card">
                    <div class="card-header">Create Car</div>

                    <div class="card-body">

                        <pre id="response" class="mb-3"></pre>

                        <input id="title" placeholder="Title" class="form-control mb-2">
                        <input id="description" placeholder="Description" class="form-control mb-2">
                        <input id="price" type="number" placeholder="Price" class="form-control mb-2">
                        <input id="photo_url" placeholder="Photo URL" class="form-control mb-2">
                        <input id="contacts" placeholder="Contacts" class="form-control mb-2">

                        <button id="submitBtn" class="btn btn-primary">
                            Отправить
                        </button>
                        <button id="generateBtn" class="btn btn-secondary ms-2">
                            Сгенерировать тестовые данные
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cars.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/cars.js') }}"></script>
@endpush
