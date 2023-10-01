<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    // OTP SimplePay tranzkaciós hibakódok 
    public function up(): void
    {
        Schema::create('simple_pay_errors', function (Blueprint $table) {
            $table->id();
            $table->text('message'); // Üzenet
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simple_pay_errors');
    }
};
