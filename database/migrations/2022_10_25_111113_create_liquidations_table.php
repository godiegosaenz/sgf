<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('voucher_number')->nullable();
            $table->decimal('total_payment',$precision = 20, $scale = 2)->nullable();
            $table->boolean('status');
            $table->char('username');
            $table->text('observation')->nullable();
            $table->integer('year');
            $table->unsignedBigInteger('type_liquidation_id')->nullable();
            $table->index('type_liquidation_id');
            $table->foreign('type_liquidation_id')->references('id')->on('type_liquidations');
            $table->unsignedBigInteger('cita_id')->nullable();
            $table->index('cita_id');
            $table->foreign('cita_id')->references('id')->on('citas');
            $table->unsignedInteger('categoria_id')->nullable();
            $table->index('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');
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
        Schema::dropIfExists('liquidations');
    }
}
