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
    Route::post('image/list', [App\Http\Controllers\SellerProductController::class, 'image_list'])->name('seller_product_image_list');

    // Képek feltöltése
    Route::post('image/upload', [App\Http\Controllers\SellerProductController::class, 'image_upload'])->name('seller_product_image_upload');

    // Vezérkép beállítása
    Route::post('image/main', [App\Http\Controllers\SellerProductController::class, 'image_main'])->name('seller_product_image_main');

    // Kép törlése
    Route::post('image/delete', [App\Http\Controllers\SellerProductController::class, 'image_delete'])->name('seller_product_image_delete');
    
    // Kép sorrend elmentése
    Route::post('image/sequence', [App\Http\Controllers\SellerProductController::class, 'image_sequence'])->name('seller_product_image_sequence');

    // Értékelések lekérdezése
    Route::post('rating', [App\Http\Controllers\SellerProductController::class, 'product_rating'])->name('seller_product_rating');

    // Értékelés moderálásának módosítása
    Route::post('rating/moderation', [App\Http\Controllers\SellerProductController::class, 'product_rating_moderation'])->name('seller_product_rating_moderation');

    // Árak lekérdezése
    Route::get('price', [App\Http\Controllers\SellerProductController::class, 'product_price'])->name('seller_product_price');

    // Ár módosítása
    Route::post('price', [App\Http\Controllers\SellerProductController::class, 'product_price_update'])->name('seller_product_price_update');

    // Aktív állapot módosítása
    Route::get('active/{id}', [App\Http\Controllers\SellerProductController::class, 'active'])->name('seller_product_active');   
});