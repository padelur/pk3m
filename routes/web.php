<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController as FrontHomeController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use App\Http\Controllers\Front\TeamController as FrontTeamController;
use App\Http\Controllers\Front\CareerController as FrontCareerController;
use App\Http\Controllers\Front\ContactController as FrontContactController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\CareerController as AdminCareerController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\PurchaseOrderController as AdminPurchaseOrderController;
use App\Http\Controllers\Admin\StockController as AdminStockController;

Route::get('/', [FrontHomeController::class, 'index'])->name('home');
Route::get('/sejarah', [FrontHomeController::class, 'history'])->name('history');

Route::get('/produk', [FrontProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [FrontProductController::class, 'show'])->name('products.show');

Route::get('/tim', [FrontTeamController::class, 'index'])->name('team.index');

Route::get('/karir', [FrontCareerController::class, 'index'])->name('careers.index');
Route::get('/karir/{id}', [FrontCareerController::class, 'show'])->name('careers.show');

Route::get('/kontak', [FrontContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [FrontContactController::class, 'store'])->name('contact.store');


Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::prefix('admin')->name('admin.')->group(function () {
		Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
		
		// User Management (Sprint 2)
		Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
		Route::get('users-datatable', [\App\Http\Controllers\Admin\UserController::class, 'datatable'])->name('users.datatable');
		Route::post('users/{user}/toggle-active', [\App\Http\Controllers\Admin\UserController::class, 'toggleActive'])->name('users.toggle-active');
		Route::get('users/{user}/permissions', [\App\Http\Controllers\Admin\UserController::class, 'permissions'])->name('users.permissions');
		Route::post('users/{user}/permissions', [\App\Http\Controllers\Admin\UserController::class, 'updatePermissions'])->name('users.update-permissions');
		
		// Supplier Management (Sprint 2)
		Route::resource('suppliers', AdminSupplierController::class);
		Route::get('suppliers-datatable', [AdminSupplierController::class, 'datatable'])->name('suppliers.datatable');
		
		// Purchase Order Management (Sprint 2)
		Route::resource('purchase-orders', AdminPurchaseOrderController::class);
		Route::get('purchase-orders-datatable', [AdminPurchaseOrderController::class, 'datatable'])->name('purchase-orders.datatable');
		Route::post('purchase-orders/{purchaseOrder}/approve', [AdminPurchaseOrderController::class, 'approve'])->name('purchase-orders.approve');
		Route::post('purchase-orders/{purchaseOrder}/send', [AdminPurchaseOrderController::class, 'send'])->name('purchase-orders.send');
		Route::get('purchase-orders/{purchaseOrder}/receive', [AdminPurchaseOrderController::class, 'showReceive'])->name('purchase-orders.receive');
		Route::post('purchase-orders/{purchaseOrder}/receive', [AdminPurchaseOrderController::class, 'receive'])->name('purchase-orders.receive');
		Route::get('purchase-orders/{purchaseOrder}/pdf', [AdminPurchaseOrderController::class, 'pdf'])->name('purchase-orders.pdf');
		
		// Stock Management (Sprint 2)
		Route::get('stocks', [AdminStockController::class, 'index'])->name('stocks.index');
		Route::get('stocks-datatable', [AdminStockController::class, 'datatable'])->name('stocks.datatable');
		Route::get('stocks/create', [AdminStockController::class, 'create'])->name('stocks.create');
		Route::post('stocks', [AdminStockController::class, 'store'])->name('stocks.store');
		// Stock Logs Datatables
		Route::get('stocks/logs', [AdminStockController::class, 'logs'])->name('stocks.logs');
		Route::get('stocks-logs-datatable', [AdminStockController::class, 'logsDatatable'])->name('stocks.logs-datatable');
		Route::get('stocks/{product}/show-datatable', [AdminStockController::class, 'showDatatable'])->name('stocks.show-datatable');
		
		Route::get('stocks/{product}/edit', [AdminStockController::class, 'edit'])->name('stocks.edit');
		Route::put('stocks/{product}', [AdminStockController::class, 'update'])->name('stocks.update');
		Route::get('stocks/{product}', [AdminStockController::class, 'show'])->name('stocks.show');
		
		// Stock Out (Sprint 3 & 4)
		Route::get('stock-outs', [\App\Http\Controllers\Admin\StockOutController::class, 'index'])->name('stock-outs.index');
		Route::get('stock-outs-datatable', [\App\Http\Controllers\Admin\StockOutController::class, 'datatable'])->name('stock-outs.datatable');
		Route::get('stock-outs/create', [\App\Http\Controllers\Admin\StockOutController::class, 'create'])->name('stock-outs.create');
		Route::post('stock-outs', [\App\Http\Controllers\Admin\StockOutController::class, 'store'])->name('stock-outs.store');
		Route::get('stock-outs/{stockOut}', [\App\Http\Controllers\Admin\StockOutController::class, 'show'])->name('stock-outs.show');
		Route::post('stock-outs/{stockOut}/approve', [\App\Http\Controllers\Admin\StockOutController::class, 'approve'])->name('stock-outs.approve');
		Route::post('stock-outs/{stockOut}/complete', [\App\Http\Controllers\Admin\StockOutController::class, 'complete'])->name('stock-outs.complete');
		Route::get('stock-outs/{stockOut}/pdf', [\App\Http\Controllers\Admin\StockOutController::class, 'pdf'])->name('stock-outs.pdf');

		// Stock Reports (Sprint 4)
		Route::get('reports/stock-logs', [\App\Http\Controllers\Admin\StockReportController::class, 'stockLogs'])->name('reports.stock-logs');
		Route::get('reports/stock-logs/pdf', [\App\Http\Controllers\Admin\StockReportController::class, 'exportStockLogsPdf'])->name('reports.stock-logs.pdf');
		Route::get('reports/stock-logs/csv', [\App\Http\Controllers\Admin\StockReportController::class, 'exportStockLogsCsv'])->name('reports.stock-logs.csv');
		Route::get('reports/stock-out', [\App\Http\Controllers\Admin\StockReportController::class, 'stockOutReport'])->name('reports.stock-out');
		Route::get('reports/stock-out/pdf', [\App\Http\Controllers\Admin\StockReportController::class, 'exportStockOutPdf'])->name('reports.stock-out.pdf');
		Route::get('reports/stock-out/csv', [\App\Http\Controllers\Admin\StockReportController::class, 'exportStockOutCsv'])->name('reports.stock-out.csv');

		// Existing routes
		Route::resource('brands', AdminBrandController::class);
		Route::get('brands-datatable', [AdminBrandController::class, 'datatable'])->name('brands.datatable');
		
		Route::resource('categories', AdminCategoryController::class);
		Route::get('categories-datatable', [AdminCategoryController::class, 'datatable'])->name('categories.datatable');
		
		Route::resource('products', AdminProductController::class);
		Route::get('products-datatable', [AdminProductController::class, 'datatable'])->name('products.datatable');
		Route::get('products/{product}/history', [AdminProductController::class, 'history'])->name('products.history');
		
		Route::resource('teams', AdminTeamController::class);
		Route::get('teams-datatable', [AdminTeamController::class, 'datatable'])->name('teams.datatable');
		
		Route::resource('careers', AdminCareerController::class);
		Route::get('careers-datatable', [AdminCareerController::class, 'datatable'])->name('careers.datatable');
		
		Route::resource('events', AdminEventController::class);
		Route::get('events-datatable', [AdminEventController::class, 'datatable'])->name('events.datatable');
		
		Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
		Route::get('settings/edit', [AdminSettingController::class, 'edit'])->name('settings.edit');
		Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
	});
});

require __DIR__.'/auth.php';
