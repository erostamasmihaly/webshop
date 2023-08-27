<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Oszlop hozzáadása
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('activation_code')->nullable(); // Aktiváló kód
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('activation_code');
        });
    }
};
