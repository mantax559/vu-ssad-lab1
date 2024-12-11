<?php

namespace App\Services;

use App\Contracts\SupplierServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;

class SupplierService implements SupplierServiceInterface
{
    public const SESSION_KEY = 'suppliers';

    public function list(array $filter): LengthAwarePaginator
    {
        $suppliers = Session::get(self::SESSION_KEY, []);

        if (isset($filter['search'])) {
            $suppliers = array_filter($suppliers, function ($supplier) use ($filter) {
                foreach ([
                    'name', 'code', 'vat_code', 'address', 'responsible_person',
                    'contact_person', 'contact_phone', 'alternate_contact_phone',
                    'email', 'alternate_email', 'billing_email', 'alternate_billing_email',
                    'certificate_code', 'comments',
                ] as $field) {
                    if (stripos($supplier[$field] ?? '', $filter['search']) !== false) {
                        return true;
                    }
                }

                return false;
            });
        }

        $suppliers = array_map(fn ($supplier) => (object) $supplier, $suppliers);

        $suppliers = collect($suppliers)->sortByDesc('id')->values();

        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedData = $suppliers->slice(($currentPage - 1) * $perPage, $perPage)->all();

        return new LengthAwarePaginator($pagedData, $suppliers->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

    public function store(array $data): object
    {
        unset($data['action']);
        $suppliers = Session::get(self::SESSION_KEY, []);

        $id = count($suppliers) > 0 ? max(array_column($suppliers, 'id')) + 1 : 1;
        $timestamp = now()->toDateTimeString();

        $data = array_merge($data, [
            'id' => $id,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        $suppliers[] = $data;
        Session::put(self::SESSION_KEY, $suppliers);

        return (object) $data;
    }

    public function update(int $supplierId, array $data): object
    {
        unset($data['action']);
        $suppliers = Session::get(self::SESSION_KEY, []);

        foreach ($suppliers as &$supplier) {
            if (cmprint($supplier['id'], $supplierId)) {
                $supplier = array_merge($supplier, $data, ['updated_at' => now()->toDateTimeString()]);
                break;
            }
        }

        Session::put(self::SESSION_KEY, $suppliers);

        return (object) $supplier;
    }

    public function destroy(int $supplierId): void
    {
        $suppliers = Session::get(self::SESSION_KEY, []);
        $suppliers = array_filter($suppliers, fn ($supplier) => ! cmprint($supplier['id'], $supplierId));
        Session::put(self::SESSION_KEY, $suppliers);
    }

    public function getSupplier(int $supplierId): object
    {
        $suppliers = Session::get(SupplierService::SESSION_KEY, []);

        return (object) collect($suppliers)->firstWhere('id', $supplierId);
    }
}
