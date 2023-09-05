<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Oszlopok hozzáadása a fizetés táblához
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->json('items'); // Kosár elemei
            $table->json('invoice'); // Felhasználó adatai
            $table->string('order_ref'); // Egyedi azonosító
            $table->string('transaction_id')->default(0); // Tranzakciós azonosító - Ha 0, akkor hiba volt
            $table->json('error')->nullable(); // Tranzakciós hiba

        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('items');
            $table->dropColumn('invoice');
            $table->dropColumn('order_ref');
            $table->dropColumn('transaction_id');
            $table->dropColumn('error');
        });
    }
};