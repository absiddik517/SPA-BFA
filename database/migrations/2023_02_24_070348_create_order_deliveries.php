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
        Schema::dropIfExists('order_deliveries');
    }
};