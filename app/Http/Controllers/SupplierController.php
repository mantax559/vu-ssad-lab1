<?php

namespace App\Http\Controllers;

use App\Contracts\SupplierServiceInterface;
use App\Services\SupplierService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct(private readonly SupplierServiceInterface $supplierService) {}

    public function index(Request $request): View
    {
        $filter = $request->all();
        $suppliers = $this->supplierService->list($filter);

        return view('suppliers.index', compact('filter', 'suppliers'));
    }

    public function create(): View
    {
        return view('suppliers.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();

        try {
            $this->supplierService->store($data);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('suppliers.index')->with('success', __('Entry successfully saved!'));
    }

    public function show($supplierId): View
    {
        $suppliers = Session::get(SupplierService::SESSION_KEY, []);
        $supplier = (object) collect($suppliers)->firstWhere('id', $supplierId);

        return view('suppliers.show', compact('supplier'));
    }

    public function edit($supplierId): View
    {
        $suppliers = Session::get(SupplierService::SESSION_KEY, []);
        $supplier = (object) collect($suppliers)->firstWhere('id', $supplierId);

        return view('suppliers.form', compact('supplier'));
    }

    public function update($supplierId, Request $request): RedirectResponse
    {
        $data = $request->all();

        try {
            $this->supplierService->update($supplierId, $data);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('suppliers.index')->with('success', __('Entry successfully saved!'));
    }

    public function destroy($supplierId): RedirectResponse
    {
        try {
            $this->supplierService->destroy($supplierId);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return back()->with('success', __('Entry successfully deleted!'));
    }
}
