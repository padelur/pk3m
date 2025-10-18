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
use App\Http\Controllers\Admin\SettingController as AdminSettingController;

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
		Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
		Route::resource('brands', AdminBrandController::class);
		Route::resource('categories', AdminCategoryController::class);
		Route::resource('products', AdminProductController::class);
		Route::get('products/{product}/history', [AdminProductController::class, 'history'])->name('products.history');
		Route::resource('teams', AdminTeamController::class);
		Route::resource('careers', AdminCareerController::class);
		Route::resource('settings', AdminSettingController::class)->only(['index','edit','update']);
	});
});

require __DIR__.'/auth.php';
