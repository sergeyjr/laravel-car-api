@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h1 class="mb-4">Create Car</h1>

                <pre id="response" class="mb-3"></pre>

                <form id="carForm">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input id="title" name="title" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input id="price" name="price" type="number" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Photo URL</label>
                        <input id="photo_url" name="photo_url" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contacts</label>
                        <input id="contacts" name="contacts" class="form-control">
                    </div>

                    <button type="button" id="submitBtn" class="btn btn-primary">
                        Отправить
                    </button>

                    <button type="button" id="generateBtn" class="btn btn-secondary ms-2">
                        Сгенерировать тестовые данные
                    </button>

                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/cars.js') }}"></script>
@endpush
