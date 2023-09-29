<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Alapesetben mégse legyen aktív az új termék
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('active')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('active')->default(1)->change();
        });
    }
};
