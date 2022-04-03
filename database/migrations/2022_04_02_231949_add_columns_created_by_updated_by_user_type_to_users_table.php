<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsCreatedByUpdatedByUserTypeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'created_by')) {
          $table->integer('created_by')->unsigned()->nullable(1);
          $table->foreign('created_by')->references('id')->on('users');
        }
        if (!Schema::hasColumn('users', 'updated_by')) {
          $table->integer('updated_by')->unsigned()->nullable(1);
          $table->foreign('updated_by')->references('id')->on('users');
        }
        if (!Schema::hasColumn('users', 'user_type_id')) {
          $table->integer('user_type_id')->unsigned()->nullable(1);
          $table->foreign('user_type_id')->references('id')->on('users_type');
        }
        if (!Schema::hasColumn('users', 'category_id')) {
          $table->integer('category_id')->unsigned()->nullable(1);
          $table->foreign('category_id')->references('id')->on('categories');
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
        if (Schema::hasColumn('users', 'created_by')) {
          $table->dropColumn('created_by');
        }
        if (Schema::hasColumn('users', 'updated_by')) {
          $table->dropColumn('updated_by');
        }
        if (Schema::hasColumn('users', 'user_type_id')) {
          $table->dropColumn('user_type_id');
        }
        if (Schema::hasColumn('users', 'category_id')) {
          $table->dropColumn('category_id');
        }
      });
    }
}
