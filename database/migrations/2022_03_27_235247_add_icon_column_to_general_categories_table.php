<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIconColumnToGeneralCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_categories', function (Blueprint $table) {
          if (!Schema::hasColumn('general_categories', 'icon')) {
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
        Schema::table('general_categories', function (Blueprint $table) {
          if (Schema::hasColumn('general_categories', 'icon')) {
            $table->dropColumn('icon');
          }
        });
    }
}
