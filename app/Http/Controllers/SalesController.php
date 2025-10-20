<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * 商品購入処理API
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchase(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($productId);

            // 在庫チェック
            if ($product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => '在庫が足りません',
                ], 400);
            }

            // salesテーブルにレコード追加
            Sale::create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'total_price' => $product->price * $quantity,
            ]);

            // 在庫減算
            $product->stock -= $quantity;
            $product->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '購入が完了しました',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => '購入処理に失敗しました',
            ], 500);
        }
    }
}
