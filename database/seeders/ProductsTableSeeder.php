<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'company_id' => 1, // 実際の companies テーブルのIDに合わせる
            'product_name' => 'サンプル商品1',
            'price' => 1000,
            'stock' => 10, // 在庫数の例
            'comment' => 'テスト用の商品です',
            'img_path' => null,
        ]);

        Product::create([
            'company_id' => 2, // 実際の companies テーブルのIDに合わせる
            'product_name' => 'サンプル商品2',
            'price' => 2000,
            'stock' => 5,
            'comment' => 'ダミーデータです',
            'img_path' => null,
        ]);
    }
}