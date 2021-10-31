<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_client', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('moneda_id');
            $table->unsignedBigInteger('renta_opcion_id');
            $table->string('pais');
            $table->string('estado');
            $table->string('ciudadMunicipio');
            $table->string('calle');
            $table->string('colonia');
            $table->string('tipoInmueble');
            $table->string('type_post');
            $table->float('precio');
            $table->string('descripcion');
            $table->string('titulo');
            $table->unsignedInteger('numExt')->nullable(1)->default(0);
            $table->unsignedInteger('numInt')->nullable(1)->default(0);
            $table->string('youtubeId')->nullable(1);
            $table->string('servicios')->nullable(1);
            $table->string('caracteristicasGenerales')->nullable(1);
            $table->string('exteriores')->nullable(1);
            $table->string('estadoConservacion')->nullable(1);
            $table->string('leflet_map')->nullable(1);
            $table->boolean('post_client_status')->nullable(1)->default(0);
            $table->unsignedInteger('num_recamaras')->nullable(1)->default(0);
            $table->unsignedInteger('num_bathroom')->nullable(1)->default(0);
            $table->unsignedInteger('num_estacionamiento')->nullable(1)->default(0);
            $table->float('superficie_construida')->nullable(1);
            $table->float('superficie_terreno')->nullable(1);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('moneda_id')->references('id')->on('divisas');
            $table->foreign('renta_opcion_id')->references('id')->on('renta_opciones');
            $table->softDeletes();
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
        Schema::dropIfExists('post_client');
    }
}
