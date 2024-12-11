<?php

namespace App\Services;

use App\Contracts\SupplierServiceInterface;
use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;
use Mantax559\LaravelHelpers\Helpers\SessionHelper;

class SupplierService implements SupplierServiceInterface
{
    public function getAll(array $filter): LengthAwarePaginator
    {
        session()->put(SessionHelper::getUrlKey(Supplier::class), request()->fullUrl());

        return Supplier::query()
            ->when(isset($filter['search']), fn ($q) => $q->whereLike([
                'company_name',
                'company_code',
                'company_vat_number',
                'company_address',
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

    public function update(string $id, array $data): Supplier
    {
        $supplier = $this->getById($id);

        $supplier->update($data);

        return $supplier;
    }

    public function destroy(string $id): void
    {
        $supplier = $this->getById($id);

        $supplier->delete();
    }

    public function getById(string $id): Supplier
    {
        return Supplier::query()->findOrFail($id);
    }
}
