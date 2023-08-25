<?php

use Illuminate\Support\Facades\Route;

// Fő oldal
Route::get('/', [App\Http\Controllers\BuyerIndexController::class, 'index'])->name('home');

// Regisztráció
Route::get('register', [App\Http\Controllers\BuyerIndexController::class, 'register'])->name('register');

// Regisztráció mentése
Route::put('register_save', [App\Http\Controllers\BuyerIndexController::class, 'register_save'])->name('register_save');