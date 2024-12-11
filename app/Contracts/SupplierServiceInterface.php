<?php

namespace App\Contracts;

use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;

interface SupplierServiceInterface
{
    public function getAll(array $filter): LengthAwarePaginator;

    public function store(array $data): Supplier;

    public function update(string $id, array $data): Supplier;

    public function destroy(string $id): void;

    public function getById(string $id): Supplier;
}
