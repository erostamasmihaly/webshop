<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Hosszú leírás mező típusának módosítása
    public function up(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->text('body')->change();
        });
    }

    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->string('body')->change();
        });
    }
};
