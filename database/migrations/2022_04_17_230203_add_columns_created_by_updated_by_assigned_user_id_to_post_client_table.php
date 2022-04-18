<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsCreatedByUpdatedByAssignedUserIdToPostClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('post_client', function (Blueprint $table) {
        if(!Schema::hasColumns('post_client',['created_by', 'updated_by', 'assigned_user_id'])) {
          $table->foreignId('created_by')->constrained('users')->nullable(1);
          $table->foreignId('updated_by')->constrained('users')->nullable(1);
          $table->foreignId('assigned_user_id')->constrained('users')->nullable(1);
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
      Schema::table('post_client', function (Blueprint $table) {
        if(Schema::hasColumns('post_client',['created_by', 'updated_by', 'assigned_user_id'])) {
          $table->dropForeign('post_client_created_by_foreign');
          $table->dropForeign('post_client_updated_by_foreign');
          $table->dropForeign('post_client_assigned_user_id_foreign');

          $table->dropColumn('created_by');
          $table->dropColumn('updated_by');
          $table->dropColumn('assigned_user_id');
        }
      });
    }
}
