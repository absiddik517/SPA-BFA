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
        Schema::create('refunds', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('season_id');
          $table->unsignedBigInteger('order_id');
          $table->unsignedBigInteger('customer_id');
          $table->unsignedBigInteger('order_item_id');
          $table->unsignedBigInteger('product_id');
          $table->float('quantity', 7, 2);
          $table->float('amount', 7, 2);
          $table->unsignedBigInteger('user_id');
          $table->date('date');
          $table->timestamps();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('season_id')->references('id')->on('seasons')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refunds');
    }
};
