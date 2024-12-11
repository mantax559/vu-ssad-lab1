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
                        <x-form::input title="{{ __('Company name') }}" required name="company_name" value="{{ $supplier->company_name ?? null }}" />
                        <x-form::input title="{{ __('Company code') }}" required name="company_code" value="{{ $supplier->company_code ?? null }}" />
                        <x-form::input title="{{ __('Company VAT number') }}" name="company_vat_number" value="{{ $supplier->company_vat_number ?? null }}" />
                        <x-form::input title="{{ __('Company address') }}" required name="company_address" value="{{ $supplier->company_address ?? null }}" />
                        <x-form::input title="{{ __('Responsible person') }}" required name="responsible_person" value="{{ $supplier->responsible_person ?? null }}" />
                        <x-form::input title="{{ __('Contact person') }}" required name="contact_person" value="{{ $supplier->contact_person ?? null }}" />
                        <x-form::input title="{{ __('Contact phone') }}" required name="contact_phone" value="{{ $supplier->contact_phone ?? null }}" />
                        <x-form::input title="{{ __('Alternate contact phone') }}" name="alternate_contact_phone" value="{{ $supplier->alternate_contact_phone ?? null }}" />
                        <x-form::input title="{{ __('Email') }}" name="email" required value="{{ $supplier->email ?? null }}" />
                        <x-form::input title="{{ __('Alternate email') }}" name="alternate_email" value="{{ $supplier->alternate_email ?? null }}" />
                        <x-form::input title="{{ __('Billing email') }}" required name="billing_email" value="{{ $supplier->billing_email ?? null }}" />
                        <x-form::input title="{{ __('Alternate billing email') }}" name="alternate_billing_email" value="{{ $supplier->alternate_billing_email ?? null }}" />
                        <x-form::input title="{{ __('Certificate code') }}" required name="certificate_code" value="{{ $supplier->certificate_code ?? null }}" />
                        <x-form::select title="{{ __('Is FSC') }}" name="is_fsc" required :collection="\App\Helpers\SelectHelper::booleanOptions()" :selected="$supplier->is_fsc ?? null" />
                        <x-form::input title="{{ __('Validation date') }}" type="datetime" name="validation_date" value="{{ $supplier->validation_date ?? null }}" required />
                        <x-form::input title="{{ __('Expiry date') }}" type="datetime" name="expiry_date" value="{{ $supplier->expiry_date ?? null }}" required />
                        <x-form::input title="{{ __('Comments') }}" name="comments" value="{{ $supplier->comments ?? null }}" />
                    </div>
                </div>
            </div>
        </div>
    </x-form::form>
@endsection
