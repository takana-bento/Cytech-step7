<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    // 認可（今回は true でOK）
    public function authorize(): bool
    {
        return true;
    }

    // バリデーションルール
    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|max:2048',
        ];
    }

    // オリジナルメッセージ
    public function messages(): array
    {
        return [
            'product_name.required' => '商品名は必須です。',
            'company_id.required' => '会社を選択してください。',
            'company_id.exists' => '選択された会社は存在しません。',
            'price.required' => '価格は必須です。',
            'price.integer' => '価格は整数で入力してください。',
            'price.min' => '価格は0以上で入力してください。',
            'stock.required' => '在庫数は必須です。',
            'stock.integer' => '在庫数は整数で入力してください。',
            'stock.min' => '在庫数は0以上で入力してください。',
            'img_path.image' => '画像ファイルを選択してください。',
            'img_path.max' => '画像サイズは2MB以下にしてください。',
        ];
    }
}