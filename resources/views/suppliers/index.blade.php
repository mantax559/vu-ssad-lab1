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
                <input type="text" title="{{ __('Search') }}" name="search" id="search" class="form-control" placeholder="Search..." />
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" id="addSupplier">Add Supplier</button>
            </div>
        </div>
        <div id="loading" style="display: none; text-align: center;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="card-body table-responsive table-card">
            <table class="table align-middle text-center mb-0">
                <thead class="text-muted table-light">
                <tr>
                    <th class="w-0">{{ __('ID') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody id="supplierTable">
                <tr id="noResults" style="display: none;">
                    <td colspan="4">{{ __('No results found.') }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">Supplier Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplierForm">
                        <input type="hidden" id="supplierId">
                        <x-form::input title="{{ __('Company name') }}" name="company_name" id="company_name" value="Random Company" required />
                        <x-form::input title="{{ __('Company code') }}" name="company_code" id="company_code" value="12345" required />
                        <x-form::input title="{{ __('Company VAT number') }}" name="company_vat_number" id="company_vat_number" value="LT123456789" />
                        <x-form::input title="{{ __('Company address') }}" name="company_address" id="company_address" value="Random Address" required />
                        <x-form::input title="{{ __('Responsible person') }}" name="responsible_person" id="responsible_person" value="John Doe" required />
                        <x-form::input title="{{ __('Contact person') }}" name="contact_person" id="contact_person" value="Jane Doe" required />
                        <x-form::input title="{{ __('Contact phone') }}" name="contact_phone" id="contact_phone" value="+37012345678" required />
                        <x-form::input title="{{ __('Alternate contact phone') }}" name="alternate_contact_phone" id="alternate_contact_phone" value="+37087654321" />
                        <x-form::input title="{{ __('Email') }}" name="email" id="email" value="info@delfi.lt" required />
                        <x-form::input title="{{ __('Alternate email') }}" name="alternate_email" id="alternate_email" value="info@delfi.lt" />
                        <x-form::input title="{{ __('Billing email') }}" name="billing_email" id="billing_email" value="info@delfi.lt" required />
                        <x-form::input title="{{ __('Alternate billing email') }}" name="alternate_billing_email" id="alternate_billing_email" value="info@delfi.lt" />
                        <x-form::input title="{{ __('Certificate code') }}" name="certificate_code" id="certificate_code" value="CERT12345" required />
                        <x-form::select title="{{ __('Is FSC') }}" name="is_fsc" id="is_fsc" required :collection="\App\Helpers\SelectHelper::booleanOptions()" />
                        <x-form::input title="{{ __('Validation date') }}" name="validation_date" id="validation_date" type="datetime" value="2024-01-01 10:00" required />
                        <x-form::input title="{{ __('Expiry date') }}" name="expiry_date" id="expiry_date" type="datetime" value="2025-01-01 10:00" required />
                        <x-form::input title="{{ __('Comments') }}" name="comments" id="comments" value="Sample comment" />
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
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
            $.ajax({
                url: `${apiUrl}?page=${page}&search=${search}`,
                type: 'GET',
                success: function (data) {
                    $('#loading').hide();
                    if (data && data.data && data.data.data && Array.isArray(data.data.data) && data.data.data.length > 0) {
                        $('#noResults').hide();
                        renderSuppliers(data.data.data);
                    } else {
                        $('#noResults').show();
                        $('#supplierTable').find('tr:not(#noResults)').remove();
                    }
                    renderPagination(data);
                },
                error: function() {
                    $('#loading').hide();
                    alert('Failed to load suppliers. Please try again.');
                }
            });
        }

        function renderSuppliers(suppliers) {
            const table = $('#supplierTable');
            table.find('tr:not(#noResults)').remove();
            suppliers.forEach(supplier => {
                table.append(`
                <tr>
                    <td>${supplier.id}</td>
                    <td>${supplier.name}</td>
                    <td>${supplier.email}</td>
                    <td>
                        <button class="btn btn-sm btn-warning edit" data-id="${supplier.id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete" data-id="${supplier.id}">Delete</button>
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
            const page = $(this).data('page');
            const search = $('#search').val();
            loadSuppliers(page, search);
        });

        $('#search').on('input', function () {
            const search = $(this).val();
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

        $(document).on('click', '.edit', function () {
            const id = $(this).data('id');
            $.ajax({
                url: `${apiUrl}/${id}`,
                type: 'PUT',
                success: function (data) {
                    $('#supplierId').val(data.id);
                    $('#company_name').val(data.company_name);
                    $('#company_code').val(data.company_code);
                    $('#company_vat_number').val(data.company_vat_number);
                    $('#company_address').val(data.company_address);
                    $('#responsible_person').val(data.responsible_person);
                    $('#contact_person').val(data.contact_person);
                    $('#contact_phone').val(data.contact_phone);
                    $('#alternate_contact_phone').val(data.alternate_contact_phone);
                    $('#email').val(data.email);
                    $('#alternate_email').val(data.alternate_email);
                    $('#billing_email').val(data.billing_email);
                    $('#alternate_billing_email').val(data.alternate_billing_email);
                    $('#certificate_code').val(data.certificate_code);
                    $('#is_fsc').val(data.is_fsc);
                    $('#validation_date').val(data.validation_date);
                    $('#expiry_date').val(data.expiry_date);
                    $('#comments').val(data.comments);
                    $('#supplierModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                }
            });
        });

        $(document).on('click', '.delete', function () {
            if (confirm('Are you sure?')) {
                const id = $(this).data('id');
                $.ajax({
                    url: `${apiUrl}/${id}`,
                    type: 'POST', // Change to POST for Laravel compatibility
                    data: {
                        _method: 'DELETE', // Specify the actual HTTP method
                        _token: '{{ csrf_token() }}' // Include the CSRF token
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

            const id = $('#supplierId').val();
            const type = id ? 'PUT' : 'POST';
            const url = id ? `${apiUrl}/${id}` : apiUrl;

            // Sukurti duomenų objektą ir pridėti CSRF žetoną
            const formData = $(this).serializeArray();
            formData.push({ name: '_token', value: '{{ csrf_token() }}' });

            // Konvertuoti duomenis į objekto formatą
            const data = {};
            formData.forEach(item => {
                data[item.name] = item.value;
            });

            // Pateikti AJAX užklausą
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
