<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralCategoriesSelectedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_categories_selected', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('general_category_id');
            $table->unsignedBigInteger('post_client_id')->nullable(1);
            $table->unsignedBigInteger('post_user_id')->nullable(1);
            $table->foreign('post_user_id')->references('id')->on('post_user');
            $table->foreign('general_category_id')->references('id')->on('general_categories');
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
        Schema::dropIfExists('general_categories_selected');
    }
}
