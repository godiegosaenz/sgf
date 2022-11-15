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
        Schema::create('citas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('persona_id')->nullable();
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->unsignedInteger('especialidades_id')->nullable();
            $table->foreign('especialidades_id')->references('id')->on('especialidades');
            $table->unsignedInteger('especialista_id')->nullable();
            $table->foreign('especialista_id')->references('persona_id')->on('especialistas');
            $table->date('fecha');
            $table->time('hora');
            $table->enum('estado', ['pendiente', 'atendido','cancelado']);
            $table->text('motivo')->nullable();
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
        Schema::dropIfExists('citas');
    }
};
