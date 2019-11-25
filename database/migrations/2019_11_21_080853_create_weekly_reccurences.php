<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyReccurences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_reccurences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('users_id');
            $table->longText('description');
            $table->time('time_start');
            $table->time('time_end');
            $table->string('reccurence_day');
            $table->integer('is_active');
            $table->foreign('users_id')->references('id')->on('users');
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
        Schema::dropIfExists('weekly_reccurences');
    }
}
