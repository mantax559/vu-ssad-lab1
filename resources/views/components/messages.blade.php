@include('components.auth-messages')

@if (session('success'))
    <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
        <b>{{ __('Success!') }}</b> {{ session('success') }}
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
        <b>{{ __('Error!') }}</b> {{ session('error') }}
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
        <b>{{ __('Error!') }}</b> {{ __('Please check the form below for errors.') }}
        <ol class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ol>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
