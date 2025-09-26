<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| ここで Web ルートを定義します。RouteServiceProvider によって
| "web" ミドルウェアグループが自動的に適用されます。
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // ------------------------------
    // ユーザー管理
    // ------------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ------------------------------
    // 商品管理
    // ------------------------------
    Route::resource('products', ProductController::class);

    // ------------------------------
    // 会社管理
    // ------------------------------
    Route::prefix('admin')->group(function () {
        Route::get('companies', [ProductController::class, 'companyIndex'])->name('admin.companies.index');
        Route::post('companies', [ProductController::class, 'storeCompany'])->name('admin.companies.store');
        Route::delete('companies/{company}', [ProductController::class, 'destroyCompany'])->name('admin.companies.destroy');
    });
});
require __DIR__ . '/auth.php';