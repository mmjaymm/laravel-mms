<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');
            $table->unsignedBigInteger('leave_type_id');
            $table->foreign('leave_type_id')->references('id')->on('leave_types');
            $table->date('date_leave');
            $table->integer('status')->default(2);
            $table->integer('reviewed_by')->nullable();
            $table->dateTime('reviewed_datetime')->nullable();
            $table->date('date_filed');
            $table->string('reason')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('attendances_id')->nullable();
            $table->foreign('attendances_id')->references('id')->on('attendances');
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('leaves');
    }
}