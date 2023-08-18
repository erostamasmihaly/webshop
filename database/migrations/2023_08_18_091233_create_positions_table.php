<?php

use App\Models\Shop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Munkakör
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Shop::class); // Melyik bolt munkaköre
            $table->string('name'); // Munkakör neve
            $table->string('summary'); // Munkakör rövid leírása
            $table->string('body')->nullable(); // Munkakör bővebb leírása
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
