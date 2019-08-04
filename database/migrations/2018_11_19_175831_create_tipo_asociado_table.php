<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoAsociadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_asociado', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->decimal('descuento',8,2);
            $table->integer('pv');
            $table->integer('dias');
            $table->integer('regalia');
            $table->integer('orden');
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
        Schema::dropIfExists('tipo_asociado');
    }
}
