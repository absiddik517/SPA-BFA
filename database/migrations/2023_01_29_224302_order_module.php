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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit');
            $table->float('rate', 6, 2);
            $table->float('transport_rate', 6, 2)->nullable();
            $table->float('max_discount', 5, 2)->default(100.00)->comment('in percentage');
            $table->timestamps();
        });
        
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('ref')->unique();
            $table->unsignedBigInteger('customer_id');
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
        
        Schema::create('customer_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('order_ref')->nullable();
            $table->enum('payment_type', [1, 2])->default(1)->comment('1: Paid sell | 2: Due Payment | [Default: Paid sell]');
            $table->string('description')->nullable();
            $table->integer('amount');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('season_id');
            $table->date('date');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('order_ref')->references('ref')->on('orders')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('restrict')->onUpdate('restrict');
        });
        
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('order_ref');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('product_id');
            $table->float('rate', 7, 2);
            $table->float('transport_rate', 7, 2)->nullable();
            $table->float('quantity', 7, 2);
            $table->integer('product_price');
            $table->integer('transport')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('amount');
            $table->string('destination')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('order_ref')->references('ref')->on('orders')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('restrict')->onUpdate('restrict');
        });
        
        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('order_ref');
            $table->unsignedBigInteger('order_item_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('dref')->unique();
            $table->float('quantity', 7, 2);
            $table->string('driver')->nullable();
            $table->string('destination')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('order_ref')->references('ref')->on('orders')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('customer_payments');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('order_deliveries');
    }
};
