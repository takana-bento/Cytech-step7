<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

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
    // 商品一覧
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    // 商品作成
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    // 商品保存
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    // 商品詳細
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    // 商品編集
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    // 商品更新
    Route::patch('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::put('products/{product}', [ProductController::class, 'update']); // PUT用
    // 商品削除
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
require __DIR__ . '/auth.php';