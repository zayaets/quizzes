@if(session('error-message'))
    <div class="alert alert-danger">{{ session('error-message') }}</div>
@endif

@if(session('success-message'))
    <div class="alert alert-success">{{ session('success-message') }}</div>
@endif
