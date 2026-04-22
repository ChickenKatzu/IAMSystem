<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AssetController;

// Login Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Inventory Routes
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/create', [InventoryController::class, 'create'])->name('create');
        Route::post('/', [InventoryController::class, 'store'])->name('store');
        // export routes
        Route::get('/export/excel', [InventoryController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [InventoryController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/print', [InventoryController::class, 'printView'])->name('print');
        // route with CRUD
        Route::get('/{id}', [InventoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [InventoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [InventoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [InventoryController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/update', [InventoryController::class, 'updateInventory'])->name('updateInventory');
        Route::get('/{id}/delete', [InventoryController::class, 'delete'])->name('delete');
        Route::put('/{id}/kurangistockModal', [InventoryController::class, 'kurangistockModal'])->name('kurangistockModal');
        Route::post('/{id}', [InventoryController::class, 'tambahstockModal'])->name('tambahstockModal');

    });

    // Asset Management Routes
    Route::prefix('assets')->name('assets.')->group(function () {
        Route::get('/', [AssetController::class, 'index'])->name('index');
        Route::get('/create', [AssetController::class, 'create'])->name('create');
        Route::post('/', [AssetController::class, 'store'])->name('store');
        // Add more asset routes
    });
});
