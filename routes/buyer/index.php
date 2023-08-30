<?php

use Illuminate\Support\Facades\Route;

// Fő oldal
Route::get('/', [App\Http\Controllers\BuyerIndexController::class, 'index'])->name('home');

// Termék oldal
Route::get('product/{id}', [App\Http\Controllers\BuyerIndexController::class, 'product'])->name('product');

// Üzlet oldala
Route::get('shop/{id}', [App\Http\Controllers\BuyerIndexController::class, 'shop'])->name('shop');

// Regisztráció
Route::get('register', [App\Http\Controllers\BuyerIndexController::class, 'register'])->name('register');

// Regisztráció mentése
Route::put('register_save', [App\Http\Controllers\BuyerIndexController::class, 'register_save'])->name('register_save');

// Regisztráció aktiválása
Route::get('register/activate/{activation_code}', [App\Http\Controllers\BuyerIndexController::class, 'register_activate'])->name('register_activate');