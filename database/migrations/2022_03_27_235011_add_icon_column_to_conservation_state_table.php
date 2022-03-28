<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIconColumnToConservationStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conservation_state', function (Blueprint $table) {
          if (!Schema::hasColumn('conservation_state', 'icon')) {
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
        Schema::table('conservation_state', function (Blueprint $table) {
          if (Schema::hasColumn('conservation_state', 'icon')) {
            $table->dropColumn('icon');
          }
        });
    }
}
