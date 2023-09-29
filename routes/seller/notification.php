<?php

use Illuminate\Support\Facades\Route;

// Eladói felület
Route::group(['prefix' => 'seller/notification'], function() {

    // Értesítések
    Route::get('', [App\Http\Controllers\SellerIndexController::class, 'notification'])->name('seller_notification');

    // Értesítést látta
    Route::get('read/{id}', [App\Http\Controllers\SellerIndexController::class, 'notification_read'])->name('seller_notification_read');

    // Összes értesítést látta
    Route::get('readall', [App\Http\Controllers\SellerIndexController::class, 'notification_readall'])->name('seller_notification_readall');

});