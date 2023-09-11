<?php

use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Egy mező törlése
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('unit_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignIdFor(Unit::class)->change();
        });
    }
};
