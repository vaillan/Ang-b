<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('Empresa');
            $table->string('nick',255);
            $table->string('last_name',100);
            $table->string('image')->nullable(1);
            $table->string('about_me')->nullable(1);
            $table->string('url_image')->nullable(1);
            $table->string('country',255)->nullable(1);
            $table->string('city',255)->nullable(1);
            $table->string('address',255)->nullable(1);
            $table->integer('postal_code')->nullable(1);
            $table->json('configuration')->nullable(1);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
