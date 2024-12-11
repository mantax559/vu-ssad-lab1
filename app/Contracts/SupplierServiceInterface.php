<?php

namespace App\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface SupplierServiceInterface
{
    public function getAll(array $filter): LengthAwarePaginator;

    public function store(array $data): object;

    public function update(int $supplierId, array $data): object;

    public function destroy(int $supplierId): void;

    public function getById(int $supplierId): object;
}
