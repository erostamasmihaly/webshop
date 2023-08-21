<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    // Újabb mezők hozzáadása
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('level')->default(0); // Szint
            $table->boolean('is_leaf')->default(1); // "Levél"? - Ha 1, akkor megadható a termékek esetén, mint kategória
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('level');
            $table->dropColumn('is_leaf');
        });
    }
};
