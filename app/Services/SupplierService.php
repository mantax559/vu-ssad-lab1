<?php

namespace App\Services;

use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;
use Mantax559\LaravelHelpers\Helpers\SessionHelper;

class SupplierService
{
    public function list(array $filter): LengthAwarePaginator
    {
        session()->put(SessionHelper::getUrlKey(Supplier::class), request()->fullUrl());

        return Supplier::query()
            ->when(isset($filter['search']), fn ($q) => $q->whereLike([
                'name',
                'code',
                'vat_code',
                'address',
                'responsible_person',
                'contact_person',
                'contact_phone',
                'alternate_contact_phone',
                'email',
                'alternate_email',
                'billing_email',
                'alternate_billing_email',
                'certificate_code',
                'comments',
            ], $filter['search']))
            ->orderByDesc('id')
            ->paginate(setting('paginate'))
            ->onEachSide(setting('on_each_side'));
    }

    public function store(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function update(Supplier $supplier, array $data): Supplier
    {
        $supplier->update($data);

        return $supplier;
    }

    public function destroy(Supplier $supplier): void
    {
        $supplier->delete();
    }
}