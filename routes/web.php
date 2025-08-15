<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplyVoucherController;
use App\Http\Controllers\DeliveryVoucherController;
use App\Http\Controllers\TransferVoucherController;
use App\Http\Controllers\InventoryAdjustmentController;
use App\Http\Controllers\WarehouseReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierTransactionController;
use App\Http\Controllers\SupplierReportController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\SupplyInvoiceController;
use App\Http\Controllers\IssueInvoiceController;
use App\Http\Controllers\ImportsController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::prefix('warehouses')->group(function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('warehouses.index');
        Route::get('/data', [WarehouseController::class, 'getData'])->name('warehouses.data');
        Route::get('/create', [WarehouseController::class, 'create'])->name('warehouses.create');
        Route::post('/', [WarehouseController::class, 'store'])->name('warehouses.store');
        Route::get('/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('warehouses.edit');
        Route::put('/{warehouse}', [WarehouseController::class, 'update'])->name('warehouses.update');
        Route::get('/{warehouse}', [WarehouseController::class, 'show'])->name('warehouses.show');
        Route::delete('/{warehouse}', [WarehouseController::class, 'destroy'])->name('warehouses.destroy');
        Route::get('/{warehouse}/items', [WarehouseController::class, 'items'])->name('warehouses.items');
        
     
    });

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('units', UnitController::class);
    Route::get('reports/low-stock', [ReportController::class, 'lowStock'])->name('reports.low-stock');
    Route::get('reports/stock-summary', [ReportController::class, 'stockSummary'])->name('reports.stock-summary');
    Route::get('reports/warehouse-stock', [ReportController::class, 'warehouseStock'])->name('reports.warehouse-stock');
    Route::prefix('supply-vouchers')->group(function () {
        Route::get('create', [SupplyVoucherController::class, 'create'])->name('supply_vouchers.create');
        Route::post('/', [SupplyVoucherController::class, 'store'])->name('supply_vouchers.store');
    });
    Route::prefix('delivery-vouchers')->group(function () {
        Route::get('create', [DeliveryVoucherController::class, 'create'])->name('delivery_vouchers.create');
        Route::post('/', [DeliveryVoucherController::class, 'store'])->name('delivery_vouchers.store');
    });

    Route::prefix('transfer-vouchers')->group(function () {
        Route::get('create', [TransferVoucherController::class, 'create'])->name('transfer_vouchers.create');
        Route::post('/', [TransferVoucherController::class, 'store'])->name('transfer_vouchers.store');
    });

    Route::get('warehouses/{warehouse}/inventory-adjustment', [InventoryAdjustmentController::class, 'create'])->name('inventory.adjustment.create');
    Route::post('inventory-adjustments', [InventoryAdjustmentController::class, 'store'])->name('inventory.adjustment.store');
    Route::get('warehouse-reports', [WarehouseReportController::class, 'index'])->name('warehouse.reports.index');
    Route::post('warehouse-reports/view', [WarehouseReportController::class, 'view'])->name('warehouse.reports.view');
     
    Route::resource('suppliers', SupplierController::class);
    Route::get('suppliers/{supplier}/transactions/create', [SupplierTransactionController::class, 'create'])->name('suppliers.transactions.create');
    Route::post('suppliers/{supplier}/transactions', [SupplierTransactionController::class, 'store'])->name('suppliers.transactions.store');
    Route::delete('supplier-transactions/{transaction}', [SupplierTransactionController::class, 'destroy'])->name('supplier-transactions.destroy');
    Route::get('supplier-transactions/{transaction}/edit', [SupplierTransactionController::class, 'edit'])->name('supplier-transactions.edit');
    Route::put('supplier-transactions/{transaction}', [SupplierTransactionController::class, 'update'])->name('supplier-transactions.update');
    Route::get('supplier-reports', [SupplierReportController::class, 'index'])->name('supplier-reports.index');
    Route::get('supplier-reports/export', [SupplierReportController::class, 'export'])->name('supplier-reports.export');
    Route::get('trucks/{truck}/loads', [TruckController::class, 'loads'])->name('trucks.loads');
    Route::resource('trucks', TruckController::class);
   
    Route::get('supply_invoices/report/export-pdf', [SupplyInvoiceController::class, 'exportReportPdf'])->name('supply_invoices.report.pdf');
    Route::get('supply_invoices/report/export-excel', [SupplyInvoiceController::class, 'exportReportExcel'])->name('supply_invoices.report.excel');

    Route::get('supply_invoices/report', [SupplyInvoiceController::class, 'report'])->name('supply_invoices.report');
    Route::resource('supply_invoices', SupplyInvoiceController::class);
    
    Route::resource('issue-invoices', IssueInvoiceController::class);

   Route::get('/imports/supply-invoices', [ImportsController::class, 'showSupplyForm'])->name('imports.supply.form');
   Route::post('/imports/supply-invoices', [ImportsController::class, 'importSupply'])->name('imports.supply.run');
   

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
