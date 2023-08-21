<?php

use App\Models\Shop;
use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Mezők hozzáadása
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('active')->default(1); // Termék elérhetősége
            $table->integer('vat')->default(27); // ÁFA
            $table->integer('discount')->default(0); // Kedvezmény
            $table->foreignIdFor(Shop::class); // Üzlet ID
            $table->foreignIdFor(Unit::class); // Mértékegység ID
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('vat');
            $table->dropColumn('discount');
            $table->dropColumn('shop_id');
            $table->dropColumn('unit_id');
        });
    }
};
