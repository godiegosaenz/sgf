<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('especialidades_id')->nullable();
            $table->foreign('especialidades_id')->references('id')->on('especialidades');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedInteger('idpersona');
            $table->foreign('idpersona')->references('id')->on('personas');
            $table->enum('tipo_usuario', ['paciente', 'especialista'])->default('especialista');
            $table->boolean('estado')->default(true);
            $table->string('titulo')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
