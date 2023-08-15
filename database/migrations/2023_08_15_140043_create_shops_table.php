<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Boltok
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Bolt neve
            $table->text('summary'); // Bolt rövid leírása
            $table->text('body')->nullable();; // Bolt bővebb leírása
            $table->string('address')->nullable();; // Bolt fizikai címe
            $table->string('url')->nullable();; // Bolt URL címe
            $table->string('email')->nullable();; // Bolt e-mail címe
            $table->string('telephone')->nullable();; // Bolt telefonszáma
            $table->double('latitude',6,4)->nullable(); // Bolt GPS szélessége
            $table->double('longitude',6,4)->nullable(); // Bolt GPS hosszúsága
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
