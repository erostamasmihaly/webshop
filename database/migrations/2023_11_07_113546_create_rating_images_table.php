<?php

use App\Models\Rating;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Értékelések fényképei
    public function up(): void
    {
        Schema::create('rating_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Rating::class);
            $table->string('filename');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rating_images');
    }
};
