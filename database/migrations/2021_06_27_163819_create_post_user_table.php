<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('localidad_id');
            $table->float('budget_minimum');
            $table->float('budget_maximum');
            $table->date('init_date');
            $table->date('end_date');
            $table->string('divisa_budget_minimum');
            $table->string('divisa_budget_maximum');
            $table->text('description');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('localidad_id')->references('id')->on('localidades');
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
        Schema::dropIfExists('post_user');
    }
}
