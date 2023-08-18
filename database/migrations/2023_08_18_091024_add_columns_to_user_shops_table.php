<?php

use App\Models\Position;
use App\Models\Shop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Újabb mezők hozzáadása
    public function up(): void
    {
        Schema::table('user_shops', function (Blueprint $table) {
            $table->foreignIdFor(Position::class); // Munkakör ID
            $table->dropColumn('shop_id'); // Bolt ID törlése >> Munkakör tartalmazza
        });
    }

    public function down(): void
    {
        Schema::table('user_shops', function (Blueprint $table) {
            $table->dropForeignIdFor('position_id');
            $table->foreignIdFor(Shop::class);
        });
    }
};
