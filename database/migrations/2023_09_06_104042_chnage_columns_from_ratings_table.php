<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Default érték adása cím esetén
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->string('title')->default('Vélemény')->change();
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->string('title')->default(false)->change();
        });
    }
};
