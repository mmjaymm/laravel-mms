<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUndertimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('undertimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('datetime_out');
            $table->string('reason');
            $table->integer('attendances_id');
            $table->integer('users_id');
            $table->integer('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('undertimes');
    }
}