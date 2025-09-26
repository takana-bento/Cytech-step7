<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileDeleteRequest extends FormRequest
{
    /**
     * ユーザーがこのリクエストを実行できるかどうか
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'current-password'], // 現在のパスワード確認
        ];
    }

    /**
     * バリデーションエラーバッグ名を指定（オプション）
     */
    public function validationData(): array
    {
        return $this->all();
    }

    /**
     * エラーバッグ名を 'userDeletion' にする（ProfileController で使用）
     */
    public function errorBag(): string
    {
        return 'userDeletion';
    }
}