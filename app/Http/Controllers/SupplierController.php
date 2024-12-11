<?php

namespace App\Http\Controllers;

use App\Contracts\SupplierServiceInterface;
use App\Http\Requests\SupplierIndexRequest;
use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct(private readonly SupplierServiceInterface $supplierService) {}

    public function index(SupplierIndexRequest $request): View
    {
        $filter = $request->validated();
        $suppliers = $this->supplierService->list($filter);

        return view('suppliers.index', compact('filter', 'suppliers'));
    }

    public function create(): View
    {
        return view('suppliers.form');
    }

    public function store(SupplierStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->supplierService->store($data);

        return redirect()->route('suppliers.index')->with('success', __('Entry successfully saved!'));
    }

    public function show(int $supplierId): View
    {
        $supplier = $this->supplierService->getSupplier($supplierId);

        return view('suppliers.show', compact('supplier'));
    }

    public function edit(int $supplierId): View
    {
        $supplier = $this->supplierService->getSupplier($supplierId);

        return view('suppliers.form', compact('supplier'));
    }

    public function update(int $supplierId, SupplierUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->supplierService->update($supplierId, $data);

        return redirect()->route('suppliers.index')->with('success', __('Entry successfully saved!'));
    }

    public function destroy(int $supplierId): RedirectResponse
    {
        $this->supplierService->destroy($supplierId);

        return back()->with('success', __('Entry successfully deleted!'));
    }
}
