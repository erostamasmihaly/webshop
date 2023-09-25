<?php

use Illuminate\Support\Facades\Route;

// Eladói felület
Route::group(['prefix' => 'seller/index'], function() {

    // Vezérlőpult
    Route::get('', [App\Http\Controllers\SellerIndexController::class, 'index'])->name('seller_index');

    // Értesítések
    Route::get('notification', [App\Http\Controllers\SellerIndexController::class, 'notification'])->name('seller_notification');

    // Értesítést látta
    Route::get('notification/read', [App\Http\Controllers\SellerIndexController::class, 'notification_read'])->name('seller_notification_read');

    // Összes értesítést látta
    Route::get('notification/readall', [App\Http\Controllers\SellerIndexController::class, 'notification_readall'])->name('seller_notification_readall');

});