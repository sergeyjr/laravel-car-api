@if(session('success'))
    <div class="alert alert-success" id="alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" id="alert-error">
        {{ session('error') }}
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info" id="alert-info">
        {{ session('info') }}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning" id="alert-warning">
        {{ session('warning') }}
    </div>
@endif

@if(session('status'))
    <div class="alert alert-primary" id="alert-status">
        {{ session('status') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger" id="alert-any">
        <strong>Пожалуйста, исправьте ошибки в форме:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(config('app.debug') && session('debug'))
    <div class="alert alert-secondary" id="alert-debug">
        <pre class="mb-0">{{ session('debug') }}</pre>
    </div>
@endif

@if(session()->has('message'))
    <div class="alert alert-info" id="alert-message">
        {{ session('message') }}
    </div>
@endif
