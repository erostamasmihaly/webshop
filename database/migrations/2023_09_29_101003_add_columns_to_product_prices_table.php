<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Bruttó és kedvezményes ár
    public function up(): void
    {
        Schema::table('product_prices', function (Blueprint $table) {
            $table->integer('brutto_price')->nullable();
            $table->integer('discount_price')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('product_prices', function (Blueprint $table) {
            $table->dropColumn('brutto_price');
            $table->dropColumn('discount_price');
        });
    }
};
