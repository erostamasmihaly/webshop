<?php

use Illuminate\Support\Facades\Route;

// Kategóriák kezelése
Route::group(['prefix' => 'admin/category'], function() {

    // Lista
    Route::get('', [App\Http\Controllers\AdminCategoryController::class, 'index'])->name('admin_category');  

    // Szerkesztés
    Route::get('edit/{id}', [App\Http\Controllers\AdminCategoryController::class, 'edit'])->name('admin_category_edit');   

    // Mentés
    Route::put('', [App\Http\Controllers\AdminCategoryController::class, 'update'])->name('admin_category_update');   

    // Létrehozás
    Route::get('create', [App\Http\Controllers\AdminCategoryController::class, 'create'])->name('admin_category_create');

});