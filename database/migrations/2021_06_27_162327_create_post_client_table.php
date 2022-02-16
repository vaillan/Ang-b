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
            $table->unsignedBigInteger('renta_opcion_id')->nullable(1);
            $table->unsignedBigInteger('ground_id')->nullable(1);
            $table->unsignedBigInteger('office_id')->nullable(1);
            $table->unsignedBigInteger('departament_id')->nullable(1);
            $table->unsignedBigInteger('house_id')->nullable(1);
            $table->string('pais');
            $table->string('estado');
            $table->string('ciudadMunicipio');
            $table->string('calle');
            $table->string('colonia');
            $table->string('titulo');
            $table->string('descripcion');
            $table->boolean('status')->nullable(1)->default(0);
            $table->float('precio',40,10);
            $table->string('type_post');
            $table->unsignedInteger('numExt')->nullable(1)->default(0);
            $table->unsignedInteger('numInt')->nullable(1)->default(0);
            $table->string('youtubeId')->nullable(1);
            $table->json('leflet_map')->nullable(1);
            $table->unsignedInteger('num_recamaras')->nullable(1)->default(0);
            $table->unsignedInteger('num_bathroom')->nullable(1)->default(0);
            $table->unsignedInteger('num_estacionamiento')->nullable(1)->default(0);
            $table->float('superficie_construida')->nullable(1)->default(0);
            $table->float('superficie_terreno')->nullable(1)->default(0);
            $table->string('otros')->nullable(1);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('moneda_id')->references('id')->on('divisas');
            $table->foreign('renta_opcion_id')->references('id')->on('renta_opciones');
            $table->foreign('ground_id')->references('id')->on('ground');
            $table->foreign('office_id')->references('id')->on('office');
            $table->foreign('departament_id')->references('id')->on('departament');
            $table->foreign('house_id')->references('id')->on('house');
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
