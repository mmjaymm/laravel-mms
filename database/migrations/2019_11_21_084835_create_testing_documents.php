<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestingDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testing_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('systems_id');
            $table->string('control_number');
            $table->date('plan_start_testing');
            $table->date('plan_end_testing');
            $table->string('scenario_number');
            $table->string('status');
            $table->string('type');
            $table->foreign('systems_id')->references('id')->on('systems');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testing_documents');
    }
}
