<?php

use Illuminate\Support\Facades\Route;

// Fő oldal
Route::get('/', [App\Http\Controllers\BuyerPublicController::class, 'index'])->name('home');

// Termék oldal
Route::get('product/{id}', [App\Http\Controllers\BuyerPublicController::class, 'product'])->name('product');

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