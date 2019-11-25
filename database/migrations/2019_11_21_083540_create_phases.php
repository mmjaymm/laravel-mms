<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phases');
            $table->date('date_plan_start');
            $table->date('date_plan_end');
            $table->unsignedBigInteger('systems_id');
            $table->date('date_actual_start');
            $table->date('date_actual_end');
            $table->foreign('systems_id')->references('id')->on('systems');
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
        Schema::dropIfExists('phases');
    }
}
