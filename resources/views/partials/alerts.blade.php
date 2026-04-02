{{-- SUCCESS --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- ERROR (общая ошибка) --}}
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- INFO --}}
@if(session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
@endif

{{-- WARNING --}}
@if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif

{{-- STATUS (Laravel auth / redirect messages) --}}
@if(session('status'))
    <div class="alert alert-primary">
        {{ session('status') }}
    </div>
@endif

{{-- VALIDATION ERRORS --}}
@if($errors->any())
    <div class="alert alert-danger">
        <strong>There were some problems with your input:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- DEBUG / DEV MESSAGE (по желанию) --}}
@if(config('app.debug') && session('debug'))
    <div class="alert alert-secondary">
        <pre class="mb-0">{{ session('debug') }}</pre>
    </div>
@endif

{{-- GENERIC FALLBACK --}}
@if(session()->has('message'))
    <div class="alert alert-info">
        {{ session('message') }}
    </div>
@endif
