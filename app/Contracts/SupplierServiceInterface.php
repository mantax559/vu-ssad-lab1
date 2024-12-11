<?php

namespace App\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface SupplierServiceInterface
{
    public function list(array $filter): LengthAwarePaginator;

    public function store(array $data): object;

    public function update($supplierId, array $data): object;

    public function destroy($supplierId): void;
}
