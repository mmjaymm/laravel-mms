<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOverTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('over_time', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('users_id');
            $table->string('overtime_type');
            $table->dateTime('datetime_in');
            $table->dateTime('datetime_out');
            $table->string('reason');
            $table->string('ot_status');
            $table->integer('reviewer_1');
            $table->integer('reviewer_2');
            $table->integer('reviewer_3');
            $table->integer('reviewer_4');
            $table->string('remarks');
            $table->foreign('users_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('over_time');
    }
}
