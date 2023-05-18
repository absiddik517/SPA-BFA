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
      Schema::create('deposits', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('season_id');
        $table->unsignedBigInteger('bank_account_id');
        $table->string('description');
        $table->float('amount', 8, 2);
        $table->string('through')->nullable();
        $table->date('date');
        $table->unsignedBigInteger('user_id');
        $table->timestamps();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        $table->foreign('season_id')->references('id')->on('seasons')->onDelete('restrict')->onUpdate('restrict');
        $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('restrict')->onUpdate('restrict');
      });
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('deposits');
    }
};
