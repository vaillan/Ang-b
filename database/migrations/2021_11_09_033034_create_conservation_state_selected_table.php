<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConservationStateSelectedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conservation_state_selected', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conservation_state_id');
            $table->unsignedBigInteger('post_client_id')->nullable(1);
            $table->unsignedBigInteger('post_user_id')->nullable(1);
            $table->foreign('post_user_id')->references('id')->on('post_user');
            $table->foreign('conservation_state_id')->references('id')->on('conservation_state');
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
        Schema::dropIfExists('conservation_state_selected');
    }
}
