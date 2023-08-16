<?php

use Illuminate\Support\Facades\Route;

// Admin felület
Route::group(['prefix' => 'admin/index'], function() {

    // Vezérlőpult
    Route::get('', [App\Http\Controllers\AdminIndexController::class, 'index'])->name('admin_index');

});