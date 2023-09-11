<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Tábla átnevezése
    public function up(): void
    {
        Schema::rename("user_shops", "user_positions");
    }

    public function down(): void
    {
        Schema::rename("user_positions", "user_shops");
    }
};
