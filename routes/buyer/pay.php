<?php

use Illuminate\Support\Facades\Route;

// Regisztráció
Route::group(['prefix' => 'pay'], function() {

    // Fizetés megerősítése
    Route::get('confirm', [App\Http\Controllers\BuyerPayController::class, 'confirm'])->name('pay_confirm');

    // Fizetés elkezdése
    Route::get('start', [App\Http\Controllers\BuyerPayController::class, 'start'])->name('pay_start');

    // Tranzakciós hiba
    Route::get('transaction_failed', [App\Http\Controllers\BuyerPayController::class, 'transaction_failed'])->name('pay_transaction_failed');

    // Tranzakciós siker
    Route::get('transaction_success', [App\Http\Controllers\BuyerPayController::class, 'transaction_success'])->name('pay_transaction_success');

    // Fizetés befejezése
    Route::get('back', [App\Http\Controllers\BuyerPayController::class, 'back'])->name('pay_back');

    // Sikeres vásárlások listája
    Route::get('history', [App\Http\Controllers\BuyerPayController::class, 'history'])->name('pay_history');

});