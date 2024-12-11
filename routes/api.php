<?php

use App\Http\Controllers\Api\SupplierController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'suppliers.'], function () {
    Route::get('suppliers', [SupplierController::class, 'index'])->name('index');
    Route::post('suppliers', [SupplierController::class, 'store'])->name('store');
    Route::get('suppliers/{id}/show', [SupplierController::class, 'show'])->name('show');
    Route::put('suppliers/{id}', [SupplierController::class, 'update'])->name('update');
    Route::delete('suppliers/{id}', [SupplierController::class, 'destroy'])->name('destroy');
});
