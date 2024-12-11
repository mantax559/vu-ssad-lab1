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
            {{ isset($supplier) ? __('Edit supplier') : __('Create supplier') }}
        @endslot
    @endcomponent
    @include('components.messages')
    <x-form::form action="{{ isset($supplier) ? route('suppliers.update', $supplier) : route('suppliers.store') }}" method="{{ isset($supplier) ? 'PUT' : 'POST' }}">
        <div class="row">
            <div class="col-12 col-xl-2 order-xl-last">
                <x-form-buttons previous-page-model="{{ \App\Models\Supplier::class }}"></x-form-buttons>
            </div>
            <div class="col-12 col-xl-10">
                <div class="card">
                    <div class="card-body row gx-3 gy-2 col-auto-width">
                        <x-form::input title="{{ __('Name') }}" name="name" value="{{ $supplier->name ?? null }}" />
                        <x-form::input title="{{ __('Code') }}" name="code" value="{{ $supplier->code ?? null }}" />
                    </div>
                </div>
            </div>
        </div>
    </x-form::form>
@endsection
