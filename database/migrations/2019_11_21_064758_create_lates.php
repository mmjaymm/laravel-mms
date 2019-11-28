<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('datetime_in');
            $table->string('reason');
            $table->integer('attendances_id')->default(0);
            $table->integer('users_id');
            $table->integer('is_deleted')->default(0);
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
        Schema::dropIfExists('lates');
    }
}