<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Termékek árai, kategóriénként!
    public function up(): void
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('size_id')->constrained(Category::class)->nullable(); // Méret
            $table->integer('quantity'); // Mennyiség
            $table->integer('price'); // Ár
            $table->integer('vat')->default(27); // ÁFA
            $table->integer('discount')->default(0); // Kedvezmény 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
