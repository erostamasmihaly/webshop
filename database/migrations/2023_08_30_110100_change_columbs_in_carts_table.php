<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Kosárban lévő termék ára lehessen ÜRES - tényleges ár majd a fizetés során mentődik el
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->integer('price')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->integer('price')->nullable(false)->change();
        });
    }
};
