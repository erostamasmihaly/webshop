<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Termékekhez tartozó képek
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('filename'); // Fájl neve
            $table->integer('sequence'); // Sorrend
            $table->boolean('is_main')->default(0); // Vezérkép - 0: nem, 1: igen
            $table->foreignIdFor(Product::class); // Termék 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
