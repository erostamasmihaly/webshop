<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    // Értékelések
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class); // Felhasználó
            $table->foreignIdFor(Product::class); // Termék
            $table->integer('stars'); // Értékelés
            $table->string('title')->nullable(); // Megjegyzés címe
            $table->text('body')->nullable(); // Megjegyzés törzse
            $table->boolean('moderated')->default(0); // Moderált, így bárki számára elérhető
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
