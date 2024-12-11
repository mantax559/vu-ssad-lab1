<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierIndexRequest;
use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Models\Supplier;
use App\Services\SupplierService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Mantax559\LaravelHelpers\Helpers\RedirectHelper;

class SupplierController extends Controller
{
    public function __construct(private readonly SupplierService $supplierService) {}

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

        try {
            $this->supplierService->store($data);
        } catch (Exception $e) {
            return back()->with('error', $this->resolveExceptionMessage($e))->withInput();
        }

        return redirect(RedirectHelper::getUrl(Supplier::class, $data['action']))->with('success', __('Entry successfully saved!'));
    }

    public function show(Supplier $supplier): View
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier): View
    {
        return view('suppliers.form', compact('supplier'));
    }

    public function update(Supplier $supplier, SupplierUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->supplierService->update($supplier, $data);
        } catch (Exception $e) {
            return back()->with('error', $this->resolveExceptionMessage($e))->withInput();
        }

        return redirect(RedirectHelper::getUrl(Supplier::class, $data['action']))->with('success', __('Entry successfully saved!'));
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        try {
            $this->supplierService->destroy($supplier);
        } catch (Exception $e) {
            return back()->with('error', $this->resolveExceptionMessage($e))->withInput();
        }

        return back()->with('success', __('Entry successfully deleted!'));
    }
}
