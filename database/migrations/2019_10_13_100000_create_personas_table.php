<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('personas')) {

        }else{
            Schema::create('personas', function (Blueprint $table) {
                $table->increments('id');
                $table->string('cedula', 10)->unique()->nullable();
                $table->string('apellidos', 250);
                $table->string('nombres', 250);
                $table->date('fechaNacimiento')->nullable();
                $table->enum('estadoCivil', ['SOLTERO/A', 'CASADO/A','DIVORSIADO/A','VIUDO/A','UNION LIBRE'])->nullable();
                $table->integer('idocupacion')->nullable();
                $table->text('ocupacion')->nullable();
                $table->string('provincia',80)->nullable();
                $table->unsignedInteger('provincia_id')->nullable();
                $table->foreign('provincia_id')->references('id')->on('provincias');
                $table->string('canton',80)->nullable();
                $table->unsignedInteger('canton_id')->nullable();
                $table->foreign('canton_id')->references('id')->on('cantones');
                $table->string('ciudad',80)->nullable();
                $table->text('direccion')->nullable();
                $table->string('telefono',12)->nullable();
                $table->string('correo',100)->nullable();
                $table->integer('secuencia_historia_clinica')->nullable();
                $table->enum('discapacidad',['SI','NO'])->nullable();
                $table->integer('porcentaje')->nullable();
                $table->text('nota')->nullable();
                $table->text('rutaimagen')->nullable();
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
