<?php

use App\Models\CategoryGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Kategória csoport hozzáadása a kategóriához
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignIdFor(CategoryGroup::class);
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('category_groups_id');
        });
    }
};
