<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('datetime_in');
            $table->dateTime('datetime_out');
            $table->string('reason');
            $table->date('date_filed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failures');
    }
}
