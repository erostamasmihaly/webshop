<?php

use Illuminate\Support\Facades\Route;

// Alkalmazotti felület
Route::group(['prefix' => 'seller/notification'], function() {

    // Értesítések
    Route::get('', [App\Http\Controllers\SellerNotificationController::class, 'index'])->name('seller_notification');

    // Értesítést látta
    Route::get('read/{id}', [App\Http\Controllers\SellerNotificationController::class, 'read'])->name('seller_notification_read');

    // Összes értesítést látta
    Route::get('readall', [App\Http\Controllers\SellerNotificationController::class, 'readall'])->name('seller_notification_readall');

});