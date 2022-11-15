<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquidationRubrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidation_rubros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rubro_id');
            $table->index('rubro_id');
            $table->foreign('rubro_id')->references('id')->on('rubros');
            $table->unsignedBigInteger('liquidation_id');
            $table->index('liquidation_id');
            $table->foreign('liquidation_id')->references('id')->on('liquidations');
            $table->decimal('value',$precision = 20, $scale = 2);
            $table->boolean('status');
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
        Schema::dropIfExists('liquidation_rubros');
    }
}
