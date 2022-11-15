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
        Schema::create('consultas', function (Blueprint $table) {
            $table->unsignedBigInteger('cita_id')->primary();
            $table->foreign('cita_id')->references('id')->on('citas');
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
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
        Schema::dropIfExists('consultas');
    }
};
