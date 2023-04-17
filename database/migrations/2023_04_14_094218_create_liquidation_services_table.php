<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidation_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('servicios_id');
            $table->index('servicios_id');
            $table->foreign('servicios_id')->references('id')->on('servicios');
            $table->unsignedBigInteger('liquidation_id');
            $table->index('liquidation_id');
            $table->foreign('liquidation_id')->references('id')->on('liquidations');
            $table->decimal('cantidad',$precision = 20, $scale = 2);
            $table->decimal('precio',$precision = 20, $scale = 2);
            $table->decimal('importe',$precision = 20, $scale = 2);
            $table->decimal('iva',$precision = 20, $scale = 2);
            $table->decimal('retencion',$precision = 20, $scale = 2);
            $table->decimal('descuento',$precision = 20, $scale = 2);
            $table->decimal('subtotal',$precision = 20, $scale = 2);
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
        Schema::dropIfExists('liquidation_services');
    }
};
