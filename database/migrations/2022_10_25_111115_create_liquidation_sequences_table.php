<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquidationSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidation_sequences', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sequence');
            $table->integer('year');
            $table->unsignedBigInteger('servicios_id');
            $table->index('servicios_id');
            $table->foreign('servicios_id')->references('id')->on('servicios');
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
        Schema::dropIfExists('liquidation_sequences');
    }
}
