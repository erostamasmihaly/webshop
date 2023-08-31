<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // További személyes adatok tárolása a fizetés miatt
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('country')->nullable(); // Ország
            $table->string('state')->nullable(); // Közigazgatási egység
            $table->string('zip')->nullable(); // Irányítószám
            $table->string('city')->nullable(); // Település
            $table->string('address')->nullable(); // Cím
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('state');
            $table->dropColumn('zip');
            $table->dropColumn('city');
            $table->dropColumn('address');
        });
    }
};
