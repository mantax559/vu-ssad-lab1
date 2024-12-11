@extends('layouts.app')

@section('content')
    @component('components.breadcrumb')
        @slot('primary')
            <a href="{{ route('home') }}">{{ __('Home') }}</a>
        @endslot
        @slot('parent')
            <a href="{{ session(\Mantax559\LaravelHelpers\Helpers\SessionHelper::getUrlKey(\App\Models\Supplier::class)) }}">{{ __('Suppliers') }}</a>
        @endslot
        @slot('title')
            {{ __('Show supplier') }}
        @endslot
    @endcomponent
    @include('components.messages')
    {{ $supplier->name }}
@endsection
