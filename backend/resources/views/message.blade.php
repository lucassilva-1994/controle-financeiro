@if (session('success'))
<div class="alert alert-success">
    <i class="bi bi-check-circle"></i> {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    <i class="bi bi-x-circle"></i> {{ session('error') }}
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <i class="bi bi-x-circle"></i> {{ $error }}<br/>
        @endforeach
</div>
@endif
