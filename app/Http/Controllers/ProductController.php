<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * 商品一覧画面を表示
     *
     * @param Request $request
     * @return View
     */ 
    public function index(Request $request): View
    {
        $query = Product::with('company');

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function($q) use ($keyword) {
                // 数字だけなら ID も検索対象
                if (ctype_digit($keyword)) {
                    $q->where('id', $keyword)
                    ->orWhere('product_name', 'like', "%{$keyword}%");
                } else {
                    $q->where('product_name', 'like', "%{$keyword}%");
                }
            });
        }

        // 会社絞り込み
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $products = $query->paginate(7)->withQueryString();
        $companies = Company::all();

        return view('products.index', compact('products', 'companies'));
    }

    /**
     * 商品新規作成画面を表示
     *
     * @return View
     */    
    public function create(): View
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    /**
     * 商品を保存
     *
     * @param Request $request
     * @return RedirectResponse
     */    
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|max:2048',
        ]);

        // 画像ファイルを保存
        if ($request->hasFile('img_path')) {
            $validated['img_path'] = $request->file('img_path')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.create')
                        ->with('success', '商品を登録しました');
    }

    /**
     * 商品詳細画面を表示
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        $product->load('company'); 
        $companies = Company::all();
        return view('products.show', compact('product', 'companies'));
    }

    /**
     * 商品編集画面を表示
     *
     * @param int $id
     * @return View
     */
    public function edit($id): View
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();

        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品情報を更新
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */    
    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // 画像ファイルを保存（新しい画像があれば更新）
        if ($request->hasFile('img_path')) {
            $validated['img_path'] = $request->file('img_path')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.edit', $product->id)
                        ->with('success', '商品情報を更新しました');
    }

    /**
     * 商品を削除
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        // ページ番号を取得（デフォルト1）
        $page = $request->input('page', 1);

        // ページ番号付きでリダイレクト
        return redirect()->route('products.index', ['page' => $page])
                        ->with('success', '商品を削除しました');
    }

    /**
     * 商品画像を削除
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroyImage(Product $product): RedirectResponse
    {
        if ($product->img_path && Storage::disk('public')->exists($product->img_path)) {
            Storage::disk('public')->delete($product->img_path);
        }

        $product->img_path = null;
        $product->save();

        return redirect()
            ->route('products.edit', $product->id)
            ->with('success', '画像を削除しました');
    }
}