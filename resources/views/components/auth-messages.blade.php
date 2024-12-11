@if (session('status'))
    <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
        <b>{{ __('Success!') }}</b> {{ session('status') }}
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('resent'))
    <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
        <b>{{ __('Success!') }}</b> {{ session('resent') }}
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
