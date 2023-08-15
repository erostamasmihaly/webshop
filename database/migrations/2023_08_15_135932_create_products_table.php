<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Termékek
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Termék neve
            $table->text('summary'); // Termék rövid leírása
            $table->text('body'); // Termék bővebb leírása
            $table->integer('price'); // Termék ára
            $table->foreignIdFor(Category::class); // Termék kategória
            $table->integer('quantity'); // Elérhető mennyiség
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
