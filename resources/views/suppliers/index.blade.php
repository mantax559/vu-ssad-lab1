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
    <div class="card mb-4">
        <div class="card-body">
            <div class="row gx-3 gy-2 col-auto-width">
                <x-form::input id="search" title="{{ __('Search') }}" name="search" value="{{ $filter['search'] ?? null }}"/>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" id="addSupplier">{{ __('Add Supplier') }}</button>
            </div>
        </div>
        <div id="loading" style="text-align: center; margin: 30px 0;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">{{ __('Loading...') }}</span>
            </div>
        </div>
        <div id="data" class="card-body table-responsive table-card" style="display: none;">
            <table class="table align-middle text-center mb-0">
                <thead class="text-muted table-light">
                <tr>
                    <th class="w-0">{{ __('Company') }}</th>
                    <th>{{ __('Is FSC') }}</th>
                    <th>{{ __('Responsible person') }}</th>
                    <th>{{ __('Contact person') }}</th>
                    <th>{{ __('Contact phone') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Billing email') }}</th>
                    <th>{{ __('Validation / Expiry') }}</th>
                    <th>{{ __('Updated / Created') }}</th>
                    <th class="w-0">{{ __('Action') }}</th>
                </tr>
                </thead>
                <tbody id="supplierTable"></tbody>
            </table>
        </div>
        <div id="noResults" class="card-body" style="display: none;">
            <div class="alert alert-info alert-border-left alert-dismissible fade show mb-0" role="alert">
                {{ __('No result was found.') }}
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <ul class="pagination justify-content-center" id="pagination"></ul> {{-- TODO: Sugryzti --}}
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">{{ __('Supplier Form') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplierForm">
                        <input type="hidden" id="supplierId">
                        <x-form::input class="mb-2" title="{{ __('Company name') }}" name="company_name" id="company_name" required/>
                        <x-form::input class="mb-2" title="{{ __('Company code') }}" name="company_code" id="company_code" required/>
                        <x-form::input class="mb-2" title="{{ __('Company VAT number') }}" name="company_vat_number" id="company_vat_number"/>
                        <x-form::input class="mb-2" title="{{ __('Company address') }}" name="company_address" id="company_address" required/>
                        <x-form::input class="mb-2" title="{{ __('Responsible person') }}" name="responsible_person" id="responsible_person" required/>
                        <x-form::input class="mb-2" title="{{ __('Contact person') }}" name="contact_person" id="contact_person" required/>
                        <x-form::input class="mb-2" title="{{ __('Contact phone') }}" name="contact_phone" id="contact_phone" required/>
                        <x-form::input class="mb-2" title="{{ __('Alternate contact phone') }}" name="alternate_contact_phone" id="alternate_contact_phone"/>
                        <x-form::input class="mb-2" title="{{ __('Email') }}" name="email" id="email" required/>
                        <x-form::input class="mb-2" title="{{ __('Alternate email') }}" name="alternate_email" id="alternate_email"/>
                        <x-form::input class="mb-2" title="{{ __('Billing email') }}" name="billing_email" id="billing_email" required/>
                        <x-form::input class="mb-2" title="{{ __('Alternate billing email') }}" name="alternate_billing_email" id="alternate_billing_email"/>
                        <x-form::input class="mb-2" title="{{ __('Certificate code') }}" name="certificate_code" id="certificate_code" required/>
                        <x-form::select class="mb-2" title="{{ __('Is FSC') }}" name="is_fsc" id="is_fsc" required :collection="\App\Helpers\SelectHelper::booleanOptions()"/>
                        <x-form::input class="mb-2" title="{{ __('Validation date') }}" name="validation_date" id="validation_date" type="datetime" required/>
                        <x-form::input class="mb-2" title="{{ __('Expiry date') }}" name="expiry_date" id="expiry_date" type="datetime" required/>
                        <x-form::input class="mb-2" title="{{ __('Comments') }}" name="comments" id="comments" />
                        <button type="submit" class="btn btn-primary w-100">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="supplierModalShow" tabindex="-1" aria-labelledby="supplierModalShowLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalShowLabel">{{ __('Supplier Show') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item"><span class="fw-bold">{{ __('Company name') }}</span>: <span id="text_company_name"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Company code') }}</span>: <span id="text_company_code"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Company VAT number') }}</span>: <span id="text_company_vat_number"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Company address') }}</span>: <span id="text_company_address"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Responsible person') }}</span>: <span id="text_responsible_person"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Contact person') }}</span>: <span id="text_contact_person"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Contact phone') }}</span>: <span id="text_contact_phone"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Alternate contact phone') }}</span>: <span id="text_alternate_contact_phone"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Email') }}</span>: <span id="text_email"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Alternate email') }}</span>: <span id="text_alternate_email"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Billing email') }}</span>: <span id="text_billing_email"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Alternate billing email') }}</span>: <span id="text_alternate_billing_email"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Certificate code') }}</span>: <span id="text_certificate_code"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Is FSC') }}</span>: <span id="text_is_fsc"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Validation date') }}</span>: <span id="text_validation_date"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Expiry date') }}</span>: <span id="text_expiry_date"></span></li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Comments') }}</span>: <span id="text_comments"></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        const apiUrl = '/api/suppliers';

        function loadSuppliers(page = 1, search = '') {
            $('#loading').show();
            $('#noResults').hide();
            $('#data').hide();
            $.ajax({
                url: `${apiUrl}?page=${page}&search=${search}`,
                type: 'GET',
                success: function (data) {
                    $('#loading').hide();
                    $('#data').show();
                    if (data && data.data && data.data.data && Array.isArray(data.data.data) && data.data.data.length > 0) {
                        $('#noResults').hide();
                        $('#data').show();
                        renderSuppliers(data.data.data);
                    } else {
                        $('#noResults').show();
                        $('#data').hide();
                    }
                    renderPagination(data);
                },
                error: function () {
                    $('#loading').hide();
                    $('#data').show();
                    alert('Failed to load suppliers. Please try again.');
                }
            });
        }

        function renderSuppliers(suppliers) {
            const table = $('#supplierTable');
            $('#noResults').hide();
            $('#data').show();
            table.find('tr').remove();
            suppliers.forEach(supplier => {
                table.append(`
                <tr>
                    <td>
                        <div>${supplier.company_name}</div>
                        <div>CC: ${supplier.company_code}</div>
                        <div>VAT: ${supplier.company_vat_number || '-'}</div>
                    </td>
                    <td>${supplier.is_fsc ? 'Yes' : 'No'}</td>
                    <td>${supplier.responsible_person}</td>
                    <td>${supplier.contact_person}</td>
                    <td>
                        <div>${supplier.contact_phone}</div>
                        <div>${supplier.alternate_contact_phone || ''}</div>
                    </td>
                    <td>
                        <div>${supplier.email}</div>
                        <div>${supplier.alternate_email || ''}</div>
                    </td>
                    <td>
                        <div>${supplier.billing_email}</div>
                        <div>${supplier.alternate_billing_email || ''}</div>
                    </td>
                    <td>
                        <div>${supplier.validation_date}</div>
                        <div>${supplier.expiry_date}</div>
                    </td>
                    <td>
                        <div>${supplier.updated_at}</div>
                        <div>${supplier.created_at}</div>
                    </td>
                    <td>
                        <div class="btn-group-vertical">
                            <button class="btn btn-sm btn-outline-primary show" data-id="${supplier.id}">Show</button>
                            <button class="btn btn-sm btn-outline-primary edit" data-id="${supplier.id}">Edit</button>
                            <button class="btn btn-sm btn-primary delete" data-id="${supplier.id}">Delete</button>
                        </div>
                    </td>
                </tr>
            `);
            });
        }

        function renderPagination(data) {
            const pagination = $('#pagination');
            pagination.empty();
            for (let i = 1; i <= data.last_page; i++) {
                pagination.append(`<li class="page-item ${i === data.current_page ? 'active' : ''}"><a href="#" class="page-link" data-page="${i}">${i}</a></li>`);
            }
        }

        $(document).on('click', '.page-link', function (e) {
            e.preventDefault();
            let page = $(this).data('page');
            let search = $('#search').val();
            loadSuppliers(page, search);
        });

        $('#search').on('input', function () {
            let search = $(this).val();
            loadSuppliers(1, search);
        });

        $('#addSupplier').on('click', function () {
            $('#supplierForm')[0].reset();
            $('#supplierId').val('');
            $('#supplierModal').modal({
                backdrop: 'static',
                keyboard: false
            }).modal('show');
        });

        $(document).on('click', '.show', function () {
            let id = $(this).data('id');
            $.ajax({
                url: `${apiUrl}/${id}/show`,
                type: 'GET',
                success: function (data) {
                    $('#text_company_name').text(data.data.company_name);
                    $('#text_company_code').text(data.data.company_code);
                    $('#text_company_vat_number').text(data.data.company_vat_number);
                    $('#text_company_address').text(data.data.company_address);
                    $('#text_responsible_person').text(data.data.responsible_person);
                    $('#text_contact_person').text(data.data.contact_person);
                    $('#text_contact_phone').text(data.data.contact_phone);
                    $('#text_alternate_contact_phone').text(data.data.alternate_contact_phone);
                    $('#text_email').text(data.data.email);
                    $('#text_alternate_email').text(data.data.alternate_email);
                    $('#text_billing_email').text(data.data.billing_email);
                    $('#text_alternate_billing_email').text(data.data.alternate_billing_email);
                    $('#text_certificate_code').text(data.data.certificate_code);
                    $('#text_validation_date').text(data.data.validation_date);
                    $('#text_expiry_date').text(data.data.expiry_date);
                    $('#text_comments').text(data.data.comments);
                    $('#text_is_fsc').text(data.data.is_fsc ? 'Yes' : 'No');
                    $('#supplierModalShow').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                }
            });
        });

        $(document).on('click', '.edit', function () {
            let id = $(this).data('id');
            $.ajax({
                url: `${apiUrl}/${id}/show`,
                type: 'GET',
                success: function (data) {
                    $('#supplierId').val(data.data.id);
                    $('#company_name').val(data.data.company_name);
                    $('#company_code').val(data.data.company_code);
                    $('#company_vat_number').val(data.data.company_vat_number);
                    $('#company_address').val(data.data.company_address);
                    $('#responsible_person').val(data.data.responsible_person);
                    $('#contact_person').val(data.data.contact_person);
                    $('#contact_phone').val(data.data.contact_phone);
                    $('#alternate_contact_phone').val(data.data.alternate_contact_phone);
                    $('#email').val(data.data.email);
                    $('#alternate_email').val(data.data.alternate_email);
                    $('#billing_email').val(data.data.billing_email);
                    $('#alternate_billing_email').val(data.data.alternate_billing_email);
                    $('#certificate_code').val(data.data.certificate_code);
                    $('#validation_date').val(data.data.validation_date);
                    $('#expiry_date').val(data.data.expiry_date);
                    $('#comments').val(data.data.comments);
                    $('#is_fsc').val(data.data.is_fsc).trigger('change');
                    $('#supplierModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                }
            });
        });

        $(document).on('click', '.delete', function () {
            if (confirm('Are you sure?')) {
                let id = $(this).data('id');
                $.ajax({
                    url: `${apiUrl}/${id}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function () {
                        loadSuppliers();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error: ", textStatus, errorThrown);
                        alert('An error occurred while processing the request.');
                    }
                });
            }
        });

        $('#supplierForm').on('submit', function (e) {
            e.preventDefault();

            let id = $('#supplierId').val();
            let type = id ? 'PUT' : 'POST';
            let url = id ? `${apiUrl}/${id}` : apiUrl;
            console.log(id);

            let formData = $(this).serializeArray();
            formData.push({name: '_token', value: '{{ csrf_token() }}'});

            let data = {};
            formData.forEach(item => {
                data[item.name] = item.value;
            });

            $.ajax({
                url: url,
                type: type,
                data: data,
                success: function () {
                    $('#supplierModal').modal('hide');
                    loadSuppliers();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error: ", textStatus, errorThrown);
                    alert('An error occurred while processing the request.');
                }
            });
        });


        $(document).ready(function () {
            loadSuppliers();
        });
    </script>
@endpush
