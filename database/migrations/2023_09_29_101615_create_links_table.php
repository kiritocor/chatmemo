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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->text('url', 2048);
            $table->foreignId('memo_id')->nullable()->constrained();   
            $table->foreignId('plan_id')->nullable()->constrained();   
            $table->foreignId('todolist_id')->nullable()->constrained();   
            $table->foreignId('think_id')->nullable()->constrained();   
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
        Schema::dropIfExists('links');
    }
};
