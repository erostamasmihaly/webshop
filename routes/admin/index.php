<?php

use Illuminate\Support\Facades\Route;

// Admin felület
Route::group(['prefix' => 'admin'], function() {

    // Vezérlőpult
    Route::get('', [App\Http\Controllers\AdminIndexController::class, 'index'])->name('admin_index');

    // Napló
    Route::get('log', [App\Http\Controllers\AdminIndexController::class, 'log'])->name('admin_log');

});