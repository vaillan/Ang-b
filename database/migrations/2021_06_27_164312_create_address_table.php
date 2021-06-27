<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_user_id')->nullable(1);
            $table->unsignedBigInteger('post_client_id')->nullable(1);
            $table->string('clave')->nullable(1);
            $table->string('estado')->nullable(1);
            $table->string('localidad')->nullable(1);
            $table->string('municipio');
            $table->string('lat');
            $table->string('lng');
            $table->string('address')->nullable(1);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('post_user_id')->references('id')->on('post_user');
            $table->foreign('post_client_id')->references('id')->on('post_client');
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
        Schema::dropIfExists('address');
    }
}
