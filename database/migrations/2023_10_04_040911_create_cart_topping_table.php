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
        Schema::create('cart_topping', function (Blueprint $table) {
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('topping_id');

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('topping_id')->references('id')->on('toppings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_topping');
    }
};
