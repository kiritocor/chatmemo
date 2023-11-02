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
        Schema::create('tag_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('record_id'); // モデルの投稿IDと関連付けるための外部キー
            $table->unsignedBigInteger('tag_id');    // タグのIDと関連付けるための外部キー
            $table->string('record_type'); // モデルの名前を格納するためのカラム
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // モデルの投稿IDと関連づけ (Think モデル)
            $table->foreign('record_id')
                ->references('id')
                ->on('thinks') // Think モデルのテーブル名
                ->name('think_record_id_foreign');

            // モデルの投稿IDと関連づけ (Memo モデル)
            $table->foreign('record_id')
                ->references('id')
                ->on('memos') // Memo モデルのテーブル名
                ->name('memo_record_id_foreign');

            // モデルの投稿IDと関連づけ (Todolist モデル)
            $table->foreign('record_id')
                ->references('id')
                ->on('todolists') // Todolist モデルのテーブル名
                ->name('todolist_record_id_foreign');

            // モデルの投稿IDと関連づけ (Plan モデル)
            $table->foreign('record_id')
                ->references('id')
                ->on('plans') // Plan モデルのテーブル名
                ->name('plan_record_id_foreign');

            // タグのIDと関連づけ
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags'); // タグのテーブル名に適切な名前を指定
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_post');
    }
};
