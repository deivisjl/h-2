<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('asociado_id')->unsigned();
            $table->integer('pedido_id')->unsigned();
            $table->integer('patrocinado_id')->unsigned();
            $table->decimal('monto',8,2);
            $table->integer('estado');
            $table->foreign('asociado_id')->references('id')->on('asociado');
            $table->foreign('pedido_id')->references('id')->on('pedido');
            $table->foreign('patrocinado_id')->references('id')->on('asociado');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comision');
    }
}
