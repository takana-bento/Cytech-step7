<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * 新規登録
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        // ユーザー作成
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // 自動ログイン
        Auth::login($user);

        // 登録後リダイレクト（例: ホーム画面）
        return redirect()->route('home')->with('success', '登録が完了しました。');
    }

    /**
     * ログイン
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // セッション固定攻撃対策
            return redirect()->intended(route('home'))->with('success', 'ログインしました。');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->onlyInput('email');
    }

    /**
     * ログアウト
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate(); // セッション破棄
        $request->session()->regenerateToken(); // CSRFトークン再生成

        return redirect()->route('login')->with('success', 'ログアウトしました。');
    }
}