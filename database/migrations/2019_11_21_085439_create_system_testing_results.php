<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTestingResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_testing_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('testing_contents_id');
            $table->string('test_result');
            $table->string('judgement');
            $table->unsignedBigInteger('users_id');
            $table->foreign('testing_contents_id')->references('id')->on('testing_contents');
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
        Schema::dropIfExists('system_testing_results');
    }
}
