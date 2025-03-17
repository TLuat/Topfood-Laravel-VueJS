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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('desc');
            $table->decimal('price', 20, 0);
            $table->string('taste');
            $table->string('nutritionNeeds'); // Nhu cầu dinh dưỡng của món ăn (ví dụ: Giảm cân, Nhiều protein, Chay, Cân đối).
            $table->text('preferences'); //Danh sách các sở thích phù hợp với món ăn (ví dụ: Tráng miệng, Hải sản, Chay, Nướng, Cay, Món Ý).
            $table->string('occasion'); // dịp ăn uống
            $table->string('type');
            $table->string('img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
