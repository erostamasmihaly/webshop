<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Mennyiség és ár törlése - máshol lesznek ezek tárolva!
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('price');
            $table->dropColumn('discount');
            $table->dropColumn('vat');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('discount');
            $table->integer('vat');
        });
    }
};
