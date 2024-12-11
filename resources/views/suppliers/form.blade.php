@extends('layouts.app')

@section('content')
    @component('components.breadcrumb')
        @slot('primary')
            <a href="{{ route('home') }}">{{ __('Home') }}</a>
        @endslot
        @slot('parent')
            <a href="{{ route('suppliers.index') }}">{{ __('Suppliers') }}</a>
        @endslot
        @slot('title')
            {{ isset($supplier) ? __('Edit supplier') : __('Create supplier') }}
        @endslot
    @endcomponent
    @include('components.messages')
    <x-form::form action="{{ isset($supplier) ? route('suppliers.update', $supplier->id) : route('suppliers.store') }}" method="{{ isset($supplier) ? 'PUT' : 'POST' }}">
        <div class="row">
            <div class="col-12 col-xl-2 order-xl-last">
                <x-form-buttons></x-form-buttons>
            </div>
            <div class="col-12 col-xl-10">
                <div class="card">
                    <div class="card-body row gx-3 gy-2 col-auto-width">
                        <x-form::input title="{{ __('Company name') }}" name="company_name" value="{{ $supplier->company_name ?? null }}" required />
                        <x-form::input title="{{ __('Company code') }}" name="company_code" value="{{ $supplier->company_code ?? null }}" required />
                        <x-form::input title="{{ __('Company VAT number') }}" name="company_vat_number" value="{{ $supplier->company_vat_number ?? null }}" />
                        <x-form::input title="{{ __('Company address') }}" name="company_address" value="{{ $supplier->company_address ?? null }}" required />
                        <x-form::input title="{{ __('Responsible person') }}" name="responsible_person" value="{{ $supplier->responsible_person ?? null }}" required />
                        <x-form::input title="{{ __('Contact person') }}" name="contact_person" value="{{ $supplier->contact_person ?? null }}" required />
                        <x-form::input title="{{ __('Contact phone') }}" name="contact_phone" value="{{ $supplier->contact_phone ?? null }}" required />
                        <x-form::input title="{{ __('Alternate contact phone') }}" name="alternate_contact_phone" value="{{ $supplier->alternate_contact_phone ?? null }}" />
                        <x-form::input title="{{ __('Email') }}" name="email" value="{{ $supplier->email ?? null }}" required />
                        <x-form::input title="{{ __('Alternate email') }}" name="alternate_email" value="{{ $supplier->alternate_email ?? null }}" />
                        <x-form::input title="{{ __('Billing email') }}" name="billing_email" value="{{ $supplier->billing_email ?? null }}" required />
                        <x-form::input title="{{ __('Alternate billing email') }}" name="alternate_billing_email" value="{{ $supplier->alternate_billing_email ?? null }}" />
                        <x-form::input title="{{ __('Certificate code') }}" name="certificate_code" value="{{ $supplier->certificate_code ?? null }}" required />
                        <x-form::select title="{{ __('Is FSC') }}" name="is_fsc" required :collection="\App\Helpers\SelectHelper::booleanOptions()" :selected="$supplier->is_fsc ?? null" />
                        <x-form::input title="{{ __('Validation date') }}" name="validation_date" value="{{ $supplier->validation_date ?? null }}" type="datetime" required />
                        <x-form::input title="{{ __('Expiry date') }}" name="expiry_date" value="{{ $supplier->expiry_date ?? null }}" type="datetime" required />
                        <x-form::input title="{{ __('Comments') }}" name="comments" value="{{ $supplier->comments ?? null }}" />
                    </div>
                </div>
            </div>
        </div>
    </x-form::form>
@endsection
