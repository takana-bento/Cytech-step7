<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;


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
    public function store(ProductRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
    
            if ($request->hasFile('img_path')) {
                $validated['img_path'] = $request->file('img_path')->store('products', 'public');
            }
    
            Product::create($validated);

            DB::commit();
            return redirect()->route('products.create')
                            ->with('success', '商品を登録しました');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', '商品登録に失敗しました。');
        }
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
    public function update(ProductRequest $request, $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
    
            $product = Product::findOrFail($id);
    
            if ($request->hasFile('img_path')) {
                $validated['img_path'] = $request->file('img_path')->store('products', 'public');
            }
    
            $product->update($validated);

            DB::commit();
            return redirect()->route('products.edit', $product->id)
                            ->with('success', '商品情報を更新しました');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', '商品更新に失敗しました。');
        }
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
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->delete();
    
            $page = $request->input('page', 1);

            DB::commit();
            return redirect()->route('products.index', ['page' => $page])
                            ->with('success', '商品を削除しました');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', '商品削除に失敗しました。');
        }
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

    /**
     * 会社登録処理
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeCompany(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        $request->validate([
            'company_name' => 'required|string|unique:companies,company_name',
        ]);
    
        try {
            Company::create([
                'company_name' => $request->company_name,
                'street_address' => $request->street_address,
                'representative_name' => $request->representative_name,
            ]);

            DB::commit();
            return redirect()->back()->with('success', '会社を登録しました');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', '会社登録に失敗しました');
        }
    }

    /**
     * 会社一覧画面を表示
     *
     * @return View
     */
    public function companyIndex(): View
    {
        $companies = Company::all();
        $products = Product::with('company')->get();

        return view('admin.companies.index', compact('companies', 'products'));
    }

    /**
     * 会社削除処理
     *
     * @param Company $company
     * @return RedirectResponse
     */
    public function destroyCompany(Company $company): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $company->delete();
            DB::commit();
            return redirect()->back()->with('success', '会社を削除しました');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', '会社削除に失敗しました');
        }
    }
}