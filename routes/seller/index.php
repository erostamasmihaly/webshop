<?php

use Illuminate\Support\Facades\Route;

// Alkalmazotti felület
Route::group(['prefix' => 'seller/index'], function() {

    // Vezérlőpult
    Route::get('', [App\Http\Controllers\SellerIndexController::class, 'index'])->name('seller_index');

});