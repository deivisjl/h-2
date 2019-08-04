<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('monto',8,2);
            $table->decimal('porcentaje',8,2);
            $table->decimal('descuento',8,2);
            $table->decimal('total',8,2)->nullable();
            $table->decimal('pv_acumulado',8,2);
            $table->integer('asociado_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->integer('estado');
            $table->foreign('asociado_id')->references('id')->on('asociado');
            $table->foreign('usuario_id')->references('id')->on('users');
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
        Schema::dropIfExists('pedido');
    }
}
