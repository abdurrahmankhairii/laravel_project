<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('concert_id');
            $table->string('image');
            $table->string('concert_name');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->text('description');
            $table->bigInteger('price');
            $table->integer('seat')->default(0);
            $table->timestamps();

            $table->foreign('concert_id')->references('id')->on('concerts')->onDelete('cascade');
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
