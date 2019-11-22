<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestingContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testing_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('test_content');
            $table->longText('assumption_result');
            $table->string('incedent_number');
            $table->unsignedBigInteger('testing_docs_id');
            $table->foreign('testing_docs_id')->references('id')->on('testing_documents');
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
        Schema::dropIfExists('testing_contents');
    }
}
