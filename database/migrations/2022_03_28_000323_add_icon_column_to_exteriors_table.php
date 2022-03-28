<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIconColumnToExteriorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('exteriors', function (Blueprint $table) {
        if (!Schema::hasColumn('exteriors', 'icon')) {
          $table->string('icon')->nullable(1);
        }
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exteriors', function (Blueprint $table) {
          if (Schema::hasColumn('exteriors', 'icon')) {
            $table->dropColumn('icon');
          }
        });
    }
}
