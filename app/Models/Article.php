<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // 一括代入可能なカラム
    protected $fillable = ['title', 'url', 'comment'];

    /**
     * 記事一覧を取得
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        // 元のDB::table('articles')->get() と同じ結果を返す
        return self::all();
    }

    /**
     * 記事を登録
     *
     * @param \Illuminate\Http\Request $request
     * @return Article
     */
    public function registArticle($request)
    {
        // 元の insert() と同じ動作
        return self::create([
            'title' => $request->title,
            'url' => $request->url,
            'comment' => $request->comment,
        ]);
    }
}
