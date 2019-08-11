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
            $table->string('email');
            $table->integer('sexo');
            $table->integer('usuario_id')->unsigned();
            $table->integer('tipo_asociado_id')->unsigned();
            $table->integer('patrocinador_id')->unsigned()->nullable();
            $table->integer('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('pais');
            $table->foreign('usuario_id')->references('id')->on('users');
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
