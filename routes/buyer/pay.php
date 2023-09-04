<?php

use Illuminate\Support\Facades\Route;

// Regisztráció
Route::group(['prefix' => 'pay'], function() {

    // Fizetés megerősítése
    Route::get('confirm', [App\Http\Controllers\BuyerPayController::class, 'confirm'])->name('pay_confirm');

});