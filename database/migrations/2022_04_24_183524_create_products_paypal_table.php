<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsPaypalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
      if (!Schema::hasTable('products_paypal')) {
        Schema::create('products_paypal', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->string('description')->nullable(1);
          $table->string('paypal_product_identifier');
          $table->string('paypal_mode');
          $table->foreignId('user_id')->constrained('users');
          $table->foreignId('created_by')->constrained('users')->nullable(1);
          $table->foreignId('updated_by')->constrained('users')->nullable(1);
          $table->softDeletes();
          $table->timestamps();
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
      if (Schema::hasTable('products_paypal')) {
        Schema::dropIfExists('products_paypal');
      }
    }
}
