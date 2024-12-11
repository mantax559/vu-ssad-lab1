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
    <ul class="list-group">
        <li class="list-group-item"><span class="fw-bold">{{ __('Company name') }}</span>: {{ $supplier->company_name }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Company code') }}</span>: {{ $supplier->company_code }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Company VAT number') }}</span>: {{ $supplier->company_vat_number ?? '-' }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Company address') }}</span>: {{ $supplier->company_address }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Responsible person') }}</span>: {{ $supplier->responsible_person }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Contact person') }}</span>: {{ $supplier->contact_person }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Contact phone') }}</span>: {{ $supplier->contact_phone }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Alternate contact phone') }}</span>: {{ $supplier->alternate_contact_phone ?? '-' }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Email') }}</span>: {{ $supplier->email }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Alternate email') }}</span>: {{ $supplier->alternate_email ?? '-' }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Billing email') }}</span>: {{ $supplier->billing_email }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Alternate billing email') }}</span>: {{ $supplier->alternate_billing_email ?? '-' }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Certificate code') }}</span>: {{ $supplier->certificate_code }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Is FSC') }}</span>: {{ $supplier->is_fsc ? __('Yes') : __('No') }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Validation date') }}</span>: {{ $supplier->validation_date }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Expiry date') }}</span>: {{ $supplier->expiry_date }}</li>
        <li class="list-group-item"><span class="fw-bold">{{ __('Comments') }}</span>: {{ $supplier->comments ?? '-' }}</li>
    </ul>
@endsection
