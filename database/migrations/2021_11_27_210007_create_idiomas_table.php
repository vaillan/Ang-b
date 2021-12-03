<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\Seeders\IdiomasSeeder;
class CreateIdiomasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idiomas', function (Blueprint $table) {
            $table->id();
            $table->string('lenguage_region_name')->nullable(0);
            $table->string('iso_code')->nullable(0);
            $table->string('flag_link')->nullable(0);
            $table->softDeletes();
            $table->timestamps();
        });
        $idiomasSeeder = new IdiomasSeeder();
        $idiomasSeeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('idiomas');
    }
}
