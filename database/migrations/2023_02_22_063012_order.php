<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('orders', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('season_id');
          $table->unsignedBigInteger('ref')->unique();
          $table->unsignedBigInteger('customer_id');
          $table->integer('sub_total');
          $table->integer('discount')->nullable();
          $table->integer('amount');
          $table->string('note')->nullable();
          $table->string('due_ref')->nullable();
          $table->date('due_date')->nullable();
          $table->date('date');
          $table->unsignedBigInteger('user_id');
          $table->timestamps();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('season_id')->references('id')->on('seasons')->onDelete('restrict')->onUpdate('restrict');
      });
      
      Schema::create('order_items', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('order_id');
          $table->unsignedBigInteger('season_id');
          $table->unsignedBigInteger('customer_id');
          $table->unsignedBigInteger('product_id');
          $table->float('rate', 7, 2);
          $table->float('transport_rate', 7, 2)->nullable();
          $table->float('quantity', 7, 2);
          $table->integer('product_price');
          $table->integer('transport')->nullable();
          $table->integer('amount');
          $table->string('destination')->nullable();
          $table->unsignedBigInteger('user_id');
          $table->date('date');
          $table->timestamps();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('season_id')->references('id')->on('seasons')->onDelete('restrict')->onUpdate('restrict');
      });
      
      Schema::create('order_deliveries', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('season_id');
          $table->unsignedBigInteger('order_id');
          $table->unsignedBigInteger('order_item_id');
          $table->unsignedBigInteger('product_id');
          $table->unsignedBigInteger('dref')->unique();
          $table->unsignedBigInteger('order_ref');
          $table->float('quantity', 7, 2);
          $table->string('driver')->nullable();
          $table->string('destination')->nullable();
          $table->date('date');
          $table->unsignedBigInteger('user_id');
          $table->timestamps();
          
          $table->foreign('season_id')->references('id')->on('seasons')->onDelete('restrict')->onUpdate('restrict');
          $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('order_ref')->references('ref')->on('orders')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('restrict');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('orders');
      Schema::dropIfExists('order_items');
      Schema::dropIfExists('order_deliveries');
    }
};
