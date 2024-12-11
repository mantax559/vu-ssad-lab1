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
        $suppliers = $this->supplierService->getAll($filter);

        return view('suppliers.index', compact('filter', 'suppliers'));
    }

    public function create(): View
    {
        return view('suppliers.form');
    }

    public function store(SupplierStoreRequest $request): RedirectResponse
    {
        $this->supplierService->store($request->validated());

        return redirect()->route('suppliers.index')->with('success', __('Entry successfully saved!'));
    }

    public function show(int $id): View
    {
        $supplier = $this->supplierService->getById($id);

        return view('suppliers.show', compact('supplier'));
    }

    public function edit(int $id): View
    {
        $supplier = $this->supplierService->getById($id);

        return view('suppliers.form', compact('supplier'));
    }

    public function update(int $id, SupplierUpdateRequest $request): RedirectResponse
    {
        $this->supplierService->update($id, $request->validated());

        return redirect()->route('suppliers.index')->with('success', __('Entry successfully saved!'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->supplierService->destroy($id);

        return back()->with('success', __('Entry successfully deleted!'));
    }
}
