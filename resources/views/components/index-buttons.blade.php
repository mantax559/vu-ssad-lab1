@props(['routeCreate', 'routeIndex'])

<div class="btn-group">
    @isset($routeCreate)
        <a class="btn btn-primary" href="{{ $routeCreate }}">
            <i class="mdi mdi-plus fs-15"></i> <span class="d-none d-xl-inline">{{ __('Create') }}</span>
        </a>
    @endisset
    {!! $slot !!}
    <a class="btn btn-outline-primary" href="{{ $routeIndex }}">
        <i class="mdi mdi-filter-remove fs-15"></i> <span class="d-none d-xl-inline">{{ __('Clear filters') }}</span>
    </a>
    <button class="btn btn-outline-primary" type="submit">
        <i class="mdi mdi-filter fs-15"></i> <span class="d-none d-xl-inline">{{ __('Filter') }}</span>
    </button>
</div>
