<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangeShuttles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_shuttles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('users_id');
            $table->dateTime('datetime_schedule');
            $table->longText('reason');
            $table->string('shuttle_status');
            $table->unsignedBigInteger('shuttle_location_id');
            $table->string('control_number');
            $table->integer('is_deleted')->default(0);
            $table->timestamps();
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('shuttle_location_id')->references('id')->on('shuttle_locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('change_shuttles');
    }
}