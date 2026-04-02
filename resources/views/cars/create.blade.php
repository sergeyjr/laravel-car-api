@extends('layouts.app')

@section('content')
    <div class="container">

        <h1 class="mb-4">Создание автомобиля</h1>

        <pre id="response" class="mb-3"></pre>

        <form id="carForm">

            <div class="row">

                <!-- LEFT -->
                <div class="col-12 col-lg-6">

                    <h4 class="mb-3">Основное</h4>

                    <div class="mb-3">
                        <label class="form-label">Заголовок (title)</label>
                        <input id="title" name="title" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Описание (description)</label>
                        <textarea id="description" name="description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Цена (price)</label>
                        <input id="price" name="price" type="number" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Фото (URL) (photo_url)</label>
                        <input id="photo_url" name="photo_url" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Контакты (contacts)</label>
                        <input id="contacts" name="contacts" class="form-control">
                    </div>

                </div>

                <!-- RIGHT -->
                <div class="col-12 col-lg-6">

                    <h4 class="mb-3">Опции автомобиля</h4>

                    <div class="mb-3">
                        <label class="form-label">Марка (brand)</label>
                        <input id="brand" name="brand" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Модель (model)</label>
                        <input id="model" name="model" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Год выпуска (year)</label>
                        <input id="year" name="year" type="number" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Кузов (body)</label>
                        <input id="body" name="body" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Пробег (mileage)</label>
                        <input id="mileage" name="mileage" type="number" class="form-control">
                    </div>

                </div>

            </div>

            <!-- BUTTONS -->
            <div class="mt-4">
                <button type="button" id="submitBtn" class="btn btn-primary">
                    Отправить
                </button>

                <button type="button" id="generateBtn" class="btn btn-secondary ms-2">
                    Сгенерировать тестовые данные
                </button>
            </div>

        </form>

    </div>
@endsection
