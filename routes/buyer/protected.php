<?php

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

// Kosár kezelése
Route::group(['prefix' => 'buyer/cart'], function() {

    // Kosár tartalma
    Route::get('', [App\Http\Controllers\BuyerProtectedController::class, 'index'])->name('buyer_cart');
    
    // Kosárba tétel
    Route::post('add', [App\Http\Controllers\BuyerProtectedController::class, 'add'])->name('buyer_cart_add')->withoutMiddleware([VerifyCsrfToken::class]);

    // Kosár módosítása
    Route::post('change', [App\Http\Controllers\BuyerProtectedController::class, 'change'])->name('buyer_cart_change')->withoutMiddleware([VerifyCsrfToken::class]);

});

// Felhasználói oldalak
Route::group(['prefix' => 'buyer/user'], function() {

    // Felhasználó adatai
    Route::get('/', [App\Http\Controllers\BuyerProtectedController::class, 'user'])->name('buyer_user');

    // Felhasználó adatainak mentése
    Route::put('/', [App\Http\Controllers\BuyerProtectedController::class, 'user_update'])->name('buyer_user_update');

});
