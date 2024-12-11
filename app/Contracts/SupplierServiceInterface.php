<?php

namespace App\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface SupplierServiceInterface
{
    public function getAll(array $filter): LengthAwarePaginator;

    public function store(array $data): object;

    public function update(int $id, array $data): object;

    public function destroy(int $id): void;

    public function getById(int $id): object;
}
