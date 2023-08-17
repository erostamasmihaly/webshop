<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    // Új oszlopok hozzáadása a felhasználóhoz
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active')->default(0); // Aktív vagy sem
            $table->string('surname'); // Vezetéknév
            $table->string('forename'); // Keresztnév
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('surname');
            $table->dropColumn('forename');
        });
    }
};
