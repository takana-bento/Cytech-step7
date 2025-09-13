<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ArticleController extends Controller
{
    /**
     * 投稿一覧を表示
     */
    public function showList(): View
    {
        $articles = Article::getList();
        return view('list', ['articles' => $articles]);
    }

    /**
     * 投稿登録フォームを表示
     */
    public function showRegistForm(): View
    {
        return view('regist');
    }

    /**
     * 投稿を登録
     */
    public function registSubmit(ArticleRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            Article::registArticle($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput();
        }

        return redirect()->route('regist');
    }
}