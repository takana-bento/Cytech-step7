<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * この商品に属する会社を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * 一括代入可能なカラム
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];
}