<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    // 登録フォーム表示（既存）
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // 登録処理（Requestクラスでバリデーション上書き）
    Route::post('register', function (RegisterRequest $request) {
        $data = $request->validated();

        $user = \App\Models\User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('login')->with('success', '登録が完了しました。ログインしてください。');
    });

    // ログインフォーム表示（既存）
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // ログイン処理（Requestクラスでバリデーション上書き）
    Route::post('login', function (LoginRequest $request) {
        $credentials = $request->validated();

        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('products.index')
                ->with('success', 'ログインしました。');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->onlyInput('email');
    });

    // パスワードリセット（既存のまま）
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    // メール認証など（既存）
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // パスワード確認
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // パスワード更新
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // ログアウト
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});