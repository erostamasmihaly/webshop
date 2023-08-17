<?php

use Illuminate\Support\Facades\Route;

// Üzletek kezelése
Route::group(['prefix' => 'admin/shop'], function() {

    // Lista
    Route::get('', [App\Http\Controllers\AdminShopController::class, 'index'])->name('admin_shop');  

    // Szerkesztés
    Route::get('edit/{id}', [App\Http\Controllers\AdminShopController::class, 'edit'])->name('admin_shop_edit');   

    // Mentés
    Route::put('', [App\Http\Controllers\AdminShopController::class, 'update'])->name('admin_shop_update');   

    // Létrehozás
    Route::get('create', [App\Http\Controllers\AdminShopController::class, 'create'])->name('admin_shop_create');

});