<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Egyéb tulajdonság megadása a kosárba tett termék esetén
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->foreignIdFor(Category::class)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
