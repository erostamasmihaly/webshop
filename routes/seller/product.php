<?php

use App\Http\Middleware\VerifyCsrfToken;
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

    // Képek lekérdezése
    Route::post('image/list', [App\Http\Controllers\SellerProductController::class, 'image_list'])->name('seller_product_image_list')->withoutMiddleware([VerifyCsrfToken::class]);

    // Képek feltöltése
    Route::post('image/upload', [App\Http\Controllers\SellerProductController::class, 'image_upload'])->name('seller_product_image_upload')->withoutMiddleware([VerifyCsrfToken::class]);

    // Vezérkép beállítása
    Route::post('image/main', [App\Http\Controllers\SellerProductController::class, 'image_main'])->name('seller_product_image_main')->withoutMiddleware([VerifyCsrfToken::class]);

    // Kép törlése
    Route::post('image/delete', [App\Http\Controllers\SellerProductController::class, 'image_delete'])->name('seller_product_image_delete')->withoutMiddleware([VerifyCsrfToken::class]);
    
    // Kép sorrend elmentése
    Route::post('image/sequence', [App\Http\Controllers\SellerProductController::class, 'image_sequence'])->name('seller_product_image_sequence')->withoutMiddleware([VerifyCsrfToken::class]);

    // Értékelések lekérdezése
    Route::post('rating', [App\Http\Controllers\SellerProductController::class, 'product_rating'])->name('seller_product_rating')->withoutMiddleware([VerifyCsrfToken::class]);

});