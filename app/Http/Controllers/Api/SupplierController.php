<?php

namespace App\Http\Controllers\Api;

use App\Contracts\SupplierServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierIndexRequest;
use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    public function __construct(private readonly SupplierServiceInterface $supplierService) {}

    public function index(SupplierIndexRequest $request): JsonResponse
    {
        try {
            $suppliers = $this->supplierService->getAll($request->validated());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'OK', 'data' => $suppliers]);
    }

    public function store(SupplierStoreRequest $request): JsonResponse
    {
        try {
            $supplier = $this->supplierService->store($request->validated());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'OK', 'data' => $supplier], 201);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $supplier = $this->supplierService->getById($id);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'OK', 'data' => $supplier]);
    }

    public function update(SupplierUpdateRequest $request, string $id): JsonResponse
    {
        try {
            $supplier = $this->supplierService->update($id, $request->validated());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'OK', 'data' => $supplier]);
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->supplierService->destroy($id);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'OK', 'data' => []]);
    }
}
