<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['company_id' => 1, 'product_name' => 'コーラ', 'price' => 130, 'stock' => 10],
            ['company_id' => 2, 'product_name' => 'サイダー', 'price' => 120, 'stock' => 5],
            ['company_id' => 3, 'product_name' => 'お茶', 'price' => 110, 'stock' => 4],
            ['company_id' => 4, 'product_name' => 'ミネラルウォーター', 'price' => 100, 'stock' => 9],
            ['company_id' => 5, 'product_name' => '炭酸水', 'price' => 110, 'stock' => 7],
            ['company_id' => 6, 'product_name' => 'スポーツドリンク', 'price' => 140, 'stock' => 15],
            ['company_id' => 7, 'product_name' => 'おしるこ', 'price' => 120, 'stock' => 8],
            ['company_id' => 8, 'product_name' => 'ポタージュ', 'price' => 120, 'stock' => 2],
            ['company_id' => 9, 'product_name' => 'いちごオレ', 'price' => 140, 'stock' => 12],
            ['company_id' => 10, 'product_name' => 'コーヒー', 'price' => 120, 'stock' => 34],
            ['company_id' => 11, 'product_name' => 'メロンソーダ', 'price' => 160, 'stock' => 15],
        ];
    
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}    
