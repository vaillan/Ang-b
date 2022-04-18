<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPasswordEncrypToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          if (!Schema::hasColumn('users', 'password_encryp')) {
            $table->string('password_encryp')->nullable(1);
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
        Schema::table('users', function (Blueprint $table) {
          if (Schema::hasColumn('users', 'password_encryp')) {
            $table->dropColumn('password_encryp');
          }
        });
    }
}
