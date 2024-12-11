@extends('layouts.app')

@section('content')
    @component('components.breadcrumb')
        @slot('primary')
            <a href="{{ route('home') }}">{{ __('Home') }}</a>
        @endslot
        @slot('title')
            {{ __('Suppliers') }}
        @endslot
    @endcomponent
    @include('components.messages')
    <x-form::form method="GET">
        <div class="card">
            <div class="card-body">
                <div class="row gx-3 gy-2 col-auto-width">
                    <x-form::input title="{{ __('Search') }}" name="search" value="{{ $filter['search'] ?? null }}"/>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <x-index-buttons route-create-permission="create-suppliers" route-create="{{ route('suppliers.create') }}" route-index="{{ route('suppliers.index') }}"></x-index-buttons>
                    <x-pagination::header :paginator="$suppliers->appends($filter)"/>
                </div>
            </div>
            @if($suppliers->count())
                <div class="card-body table-responsive table-card">
                    <table class="table align-middle text-center mb-0">
                        <thead class="text-muted table-light">
                        <tr>
                            <th class="w-0">{{ __('Name') }}</th>
                            <th>{{ __('Code') }}</th>
                            <th>{{ __('Updated / Created') }}</th>
                            <th class="w-0">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($suppliers as $index => $supplier)
                            <tr>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->code }}</td>
                                <td>{{ $supplier->updated_at }}<br>{{ $supplier->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('suppliers.show', $supplier) }}">{{ __('Show') }}</a>
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('suppliers.edit', $supplier) }}">{{ __('Edit') }}</a>
                                        <x-form::modal-button id="delete{{ $index }}" class="btn btn-sm btn-primary">{{ __('Delete') }}</x-form::modal-button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <x-pagination::footer :paginator="$suppliers->appends($filter)"/>
                </div>
            @else
                <div class="card-body">
                    <div class="alert alert-info alert-border-left alert-dismissible fade show mb-0" role="alert">
                        {{ __('No result was found.') }}
                    </div>
                </div>
            @endif
        </div>
    </x-form::form>
@endsection

@push('modals')
    @foreach($suppliers as $index => $supplier)
        <x-form::modal id="delete{{ $index }}" title="{{ __('Delete entry') }}" action="{{ route('suppliers.destroy', $supplier) }}" method="DELETE" submitText="{{ __('Delete') }}">
            {{ __('Are you sure you want to remove this entry?') }}
        </x-form::modal>
    @endforeach
@endpush
