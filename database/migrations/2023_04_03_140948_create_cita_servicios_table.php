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
        Schema::create('cita_servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('servicio_id');
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->unsignedBigInteger('cita_id');
            $table->foreign('cita_id')->references('id')->on('citas');
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
        Schema::dropIfExists('cita_servicios');
    }
};
