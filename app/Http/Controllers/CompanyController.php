<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CompanyController extends Controller
{
    /**
     * 会社一覧画面
     */
    public function index(): View
    {
        $companies = Company::all();
        $products = \App\Models\Product::with('company')->get();

        return view('admin.companies.index', compact('companies', 'products'));
    }

    /**
     * 新しい会社を登録
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'company_name' => 'required|string|unique:companies,company_name',
        ]);

        Company::create([
            'company_name' => $request->company_name,
            'street_address' => $request->street_address,
            'representative_name' => $request->representative_name,
        ]);

        return redirect()->route('admin.companies.index')
                        ->with('success', '会社を登録しました');
    }

    /**
     * 会社を削除
     */
    public function destroy(int $id): RedirectResponse
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('admin.companies.index')
                        ->with('success', '会社を削除しました');
    }
}
