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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('json_value')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });
        
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->integer('share');
            $table->timestamps();
        });
        
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->date('start');
            $table->date('end');
            $table->enum('status', [true, false])->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
        Schema::dropIfExists('owners');
        Schema::dropIfExists('seasons');
    }
};
