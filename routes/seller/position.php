<?php

use Illuminate\Support\Facades\Route;

// Munkakörök kezelése
Route::group(['prefix' => 'seller/position'], function() {

    // Lista
    Route::get('', [App\Http\Controllers\SellerPositionController::class, 'index'])->name('seller_position');  

    // Szerkesztés
    Route::get('{id}', [App\Http\Controllers\SellerPositionController::class, 'edit'])->name('seller_position_edit');   

    // Mentés
    Route::put('', [App\Http\Controllers\SellerPositionController::class, 'update'])->name('seller_position_update');   

    // Létrehozás
    Route::get('create', [App\Http\Controllers\SellerPositionController::class, 'create'])->name('seller_position_create');
 
});