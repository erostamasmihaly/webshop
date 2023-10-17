<?php

use Illuminate\Support\Facades\Route;

// Üzletek kezelése
Route::group(['prefix' => 'admin/shop'], function() {

    // Lista
    Route::get('', [App\Http\Controllers\AdminShopController::class, 'index'])->name('admin_shop');  

    // Szerkesztés
    Route::get('{id}', [App\Http\Controllers\AdminShopController::class, 'edit'])->name('admin_shop_edit');   

    // Mentés
    Route::put('', [App\Http\Controllers\AdminShopController::class, 'update'])->name('admin_shop_update');   

    // Létrehozás
    Route::get('create', [App\Http\Controllers\AdminShopController::class, 'create'])->name('admin_shop_create');

    // Alkalmazott szerkesztése
    Route::get('user_edit/{shopId}/{userId}/{prevPositionId}', [App\Http\Controllers\AdminShopController::class, 'user_edit'])->name('admin_shop_user_edit'); 

    // Alkalmazott mentése
    Route::put('user', [App\Http\Controllers\AdminShopController::class, 'user_update'])->name('admin_shop_user_update'); 

});