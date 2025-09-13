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
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');          // BIGINTの自動増分ID（主キー）
            $table->string('title');              // VARCHAR(255)のtitleカラム
            $table->string('url');                // VARCHAR(255)のurlカラム
            $table->text('comment')->nullable(); // TEXT型のcommentカラム。nullを許可
            $table->timestamps();                 // created_at, updated_atのタイムスタンプ
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};


