<?php

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

// Kategóriák kezelése
Route::group(['prefix' => 'buyer/cart'], function() {

    // Kosár tartalma
    Route::get('', [App\Http\Controllers\BuyerCartController::class, 'index'])->name('buyer_cart');
    
    // Kosárba tétel
    Route::post('add', [App\Http\Controllers\BuyerCartController::class, 'add'])->name('buyer_cart_add')->withoutMiddleware([VerifyCsrfToken::class]);

});