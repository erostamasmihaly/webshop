<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken;

// Fő oldal
Route::get('/', [App\Http\Controllers\BuyerPublicController::class, 'index'])->name('home');

// Fő oldalon lévő termékek
Route::get('products', [App\Http\Controllers\BuyerPublicController::class, 'products'])->name('products');

// Termék oldal
Route::get('product/{id}', [App\Http\Controllers\BuyerPublicController::class, 'product'])->name('product');

// Termék értékelései
Route::post('rating', [App\Http\Controllers\BuyerPublicController::class, 'product_rating'])->name('product_rating');

// Üzlet oldala
Route::get('shop/{id}', [App\Http\Controllers\BuyerPublicController::class, 'shop'])->name('shop');

// Regisztráció
Route::group(['prefix' => 'register'], function() {

    // Regisztrációs oldal
    Route::get('/', [App\Http\Controllers\BuyerPublicController::class, 'register'])->name('register');

    // Regisztráció mentése
    Route::put('save', [App\Http\Controllers\BuyerPublicController::class, 'register_save'])->name('register_save');

    // Regisztráció aktiválása
    Route::get('activate/{activation_code}', [App\Http\Controllers\BuyerPublicController::class, 'register_activate'])->name('register_activate');

});