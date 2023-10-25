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
        Schema::table('thinks', function (Blueprint $table) {
            $table->string('when', 200)->nullable();
            $table->string('important', 50)->nullable();
            $table->string('about', 200)->nullable();
            $table->string('w_think', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thinks', function (Blueprint $table) {
            //
        });
    }
};
