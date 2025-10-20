<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * この会社が所有する商品を取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
{
    return $this->hasMany(Product::class);
}

    /**
     * 一括代入可能なカラム
     *
     * @var array
     */

    protected $fillable = [
        'company_name',
        'street_address',
        'representative_name',
    ];
}