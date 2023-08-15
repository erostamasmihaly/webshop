<?php

use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Felhasználó kosara
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class); // Felhasználó ID
            $table->foreignIdFor(Product::class); // Termék ID
            $table->foreignIdFor(Payment::class)->nullable(); // Vásárlás ID
            $table->integer('quantity'); // Mennyiség
            $table->integer('price'); // Aktuális ár
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
