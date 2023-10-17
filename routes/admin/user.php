<?php

use Illuminate\Support\Facades\Route;

// Felhasználók kezelése
Route::group(['prefix' => 'admin/user'], function() {

    // Lista
    Route::get('', [App\Http\Controllers\AdminUserController::class, 'index'])->name('admin_user');  

    // Szerkesztés
    Route::get('{id}', [App\Http\Controllers\AdminUserController::class, 'edit'])->name('admin_user_edit');   

    // Mentés
    Route::put('', [App\Http\Controllers\AdminUserController::class, 'update'])->name('admin_user_update');   

    // Létrehozás
    Route::get('create', [App\Http\Controllers\AdminUserController::class, 'create'])->name('admin_user_create');

});