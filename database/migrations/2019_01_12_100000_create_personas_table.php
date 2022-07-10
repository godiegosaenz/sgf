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
                $table->string('cedula', 10)->unique();
                $table->string('apellidos', 250);
                $table->string('nombres', 250);
                $table->date('fechaNacimiento');
                $table->enum('estadoCivil', ['SOLTERO/A', 'CASADO/A','DIVORSIADO/A','VIUDO/A','UNION LIBRE']);
                $table->integer('idocupacion')->nullable();
                $table->text('ocupacion')->nullable();
                $table->string('provincia',60)->nullable();
                $table->string('canton',60)->nullable();
                $table->string('ciudad',60)->nullable();
                $table->text('direccion')->nullable();
                $table->string('telefono',12)->nullable();
                $table->enum('discapacidad',['SI','NO'])->nullable();
                $table->integer('porcentaje')->nullable();
                $table->text('nota')->nullable();
                $table->text('rutaimagen')->nullable();
                $table->char('historiaClinica',8)->nullable();
                $table->integer('idhistoriaClinica')->nullable();
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
