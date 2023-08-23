<?php

use Illuminate\Support\Facades\Route;

// Fő oldal
Route::get('/', [App\Http\Controllers\BuyerIndexController::class, 'index'])->name('home');

// Vásárlói felület
Route::group(['prefix' => 'seller/index'], function() {

});