<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group
| assigned the "api" middleware group. Enjoy building your API!
|
*/

// ログインユーザー情報取得API（既存）
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 購入API（新規追加）
Route::post('/purchase', [SalesController::class, 'purchase']);
