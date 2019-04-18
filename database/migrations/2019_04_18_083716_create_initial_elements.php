<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initial_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('element_id');
            $table->timestamps();

            $table->foreign('element_id')->references('id')->on('elements')->onDuplicate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('initial_elements');
    }
}
