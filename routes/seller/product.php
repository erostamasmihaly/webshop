<?php

use Illuminate\Support\Facades\Route;

// Termékek kezelése
Route::group(['prefix' => 'seller/product'], function() {

    // Lista
    Route::get('', [App\Http\Controllers\SellerProductController::class, 'index'])->name('seller_product');  

    // Szerkesztés
    Route::get('edit/{id}', [App\Http\Controllers\SellerProductController::class, 'edit'])->name('seller_product_edit');   

    // Mentés
    Route::put('', [App\Http\Controllers\SellerProductController::class, 'update'])->name('seller_product_update');   

    // Létrehozás
    Route::get('create', [App\Http\Controllers\SellerProductController::class, 'create'])->name('seller_product_create');

    // Képek feltöltése
    Route::post('image/upload', [App\Http\Controllers\SellerProductController::class, 'image_upload'])->name('seller_product_image_upload')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;

});