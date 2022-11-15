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
            $table->unsignedBigInteger('type_liquidation_id');
            $table->index('type_liquidation_id');
            $table->foreign('type_liquidation_id')->references('id')->on('type_liquidations');
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
