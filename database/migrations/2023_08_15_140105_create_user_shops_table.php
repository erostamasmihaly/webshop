<?php

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    // Bolt <> Felhasználó
    public function up(): void
    {
        Schema::create('user_shops', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class); // Felhasználó ID
            $table->foreignIdFor(Shop::class); // Bolt ID
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_shops');
    }
};
