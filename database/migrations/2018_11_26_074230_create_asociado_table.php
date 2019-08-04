<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsociadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asociado', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sh')->nullable();
            $table->string('nombres');
            $table->string('apellidos');
            $table->bigInteger('dpi');
            $table->text('direccion');
            $table->bigInteger('telefono');
            $table->string('correo');
            $table->integer('tipo_asociado_id')->unsigned();
            $table->integer('patrocinador_id')->unsigned()->nullable();
            $table->integer('municipio_id')->unsigned();
            $table->foreign('tipo_asociado_id')->references('id')->on('tipo_asociado');
            $table->foreign('municipio_id')->references('id')->on('municipio');
            $table->softDeletes();
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
        Schema::dropIfExists('asociado');
    }
}
