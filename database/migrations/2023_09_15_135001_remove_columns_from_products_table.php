<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Kategóriával kapcsolatos mezők törlése
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('unit_id');
            $table->dropColumn('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('unit_id')->constrained('categories');
            $table->foreignIdFor(Category::class);
        });
    }
};
