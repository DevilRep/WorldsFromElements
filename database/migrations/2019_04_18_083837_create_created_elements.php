<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreatedElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('created_elements', function (Blueprint $table) {
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
        Schema::dropIfExists('created_elements');
    }
}
