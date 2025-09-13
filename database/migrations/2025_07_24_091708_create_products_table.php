<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();                              // ID
            $table->unsignedBigInteger('company_id');  // 会社ID（外部キー）
            $table->string('product_name');            // 商品名
            $table->integer('price');                  // 価格
            $table->integer('stock');                  // 在庫数
            $table->text('comment')->nullable();       // コメント
            $table->string('img_path')->nullable();    // 画像パス
            $table->timestamps();

            // 外部キー制約
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
