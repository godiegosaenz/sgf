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
        Schema::create('servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('status');
            $table->boolean('es_bono')->default(false);
            $table->decimal('precio',$precision = 20, $scale = 2)->nullable();
            $table->decimal('importe',$precision = 20, $scale = 2)->nullable();
            $table->decimal('descuento',$precision = 20, $scale = 2)->nullable();
            $table->decimal('retencion',$precision = 20, $scale = 2)->nullable();
            $table->decimal('iva',$precision = 20, $scale = 2)->nullable();
            $table->decimal('subtotal',$precision = 20, $scale = 2)->nullable();
            //$table->unsignedInteger('especialidades_id')->nullable();
            //$table->foreign('especialidades_id')->references('id')->on('especialidades');
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
        Schema::dropIfExists('servicios');
    }
};
