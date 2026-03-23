@extends('app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div id="app">

                    <div class="card">
                        <div class="card-header">Laravel</div>

                        <div class="card-body">

                            <p>You are logged in!</p>

                            <h3>Создать машину</h3>

                            <input v-model="form.title" placeholder="Title" class="form-control mb-2">
                            <input v-model="form.description" placeholder="Description" class="form-control mb-2">
                            <input v-model="form.price" type="number" placeholder="Price" class="form-control mb-2">
                            <input v-model="form.photo_url" placeholder="Photo URL" class="form-control mb-2">
                            <input v-model="form.contacts" placeholder="Contacts" class="form-control mb-2">

                            <button @click="submit" class="btn btn-primary">
                                Отправить
                            </button>

                            <pre class="mt-3">@{{ response }}</pre>

                        </div>
                    </div>

                </div><!-- /#app -->

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="/js/app.js"></script>

@endsection
