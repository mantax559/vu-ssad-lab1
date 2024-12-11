<?php

namespace App\Contracts;

use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;

interface SupplierServiceInterface
{
    public function getAll(array $filter): LengthAwarePaginator;

    public function store(array $data): Supplier;

    public function update(Supplier $supplier, array $data): Supplier;

    public function destroy(Supplier $supplier): void;

    public function getById(int $id): Supplier;
}
