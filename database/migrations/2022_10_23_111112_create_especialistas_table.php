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
        Schema::create('especialistas', function (Blueprint $table) {
            $table->integer('persona_id')->unsigned();
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->unsignedInteger('especialidades_id')->nullable();
            $table->foreign('especialidades_id')->references('id')->on('especialidades');
            $table->string('titulo');
            $table->boolean('activo');
            $table->foreign('persona_id')->references('id')->on('personas');
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
        Schema::dropIfExists('especialistas');
    }
};
