<?php

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

// Kosár kezelése
Route::group(['prefix' => 'buyer/cart'], function() {

    // Kosár tartalma
    Route::get('', [App\Http\Controllers\BuyerProtectedController::class, 'cart'])->name('buyer_cart');
    
    // Kosárba tétel
    Route::post('add', [App\Http\Controllers\BuyerProtectedController::class, 'cart_add'])->name('buyer_cart_add');

    // Kosár módosítása
    Route::post('change', [App\Http\Controllers\BuyerProtectedController::class, 'cart_change'])->name('buyer_cart_change');

});

// Kedvelés
Route::group(['prefix' => 'buyer/favourite'], function() {

    // Kedvelés módosítása
    Route::post('change', [App\Http\Controllers\BuyerProtectedController::class, 'favourite_change'])->name('buyer_favourite_change');

});

// Értékelés
Route::group(['prefix' => 'buyer/rating'], function() {

    // Kedvelés módosítása
    Route::post('change', [App\Http\Controllers\BuyerProtectedController::class, 'rating_change'])->name('buyer_rating_change');

});

// Felhasználói oldalak
Route::group(['prefix' => 'buyer/user'], function() {

    // Felhasználó adatai
    Route::get('/', [App\Http\Controllers\BuyerProtectedController::class, 'user'])->name('buyer_user');

    // Felhasználó adatainak mentése
    Route::put('/', [App\Http\Controllers\BuyerProtectedController::class, 'user_update'])->name('buyer_user_update');

});

// Értesítés felület
Route::group(['prefix' => 'buyer/notification'], function() {

    // Értesítések
    Route::get('', [App\Http\Controllers\BuyerNotificationController::class, 'index'])->name('buyer_notification');

    // Értesítést látta
    Route::get('read/{id}', [App\Http\Controllers\BuyerNotificationController::class, 'read'])->name('buyer_notification_read');

    // Összes értesítést látta
    Route::get('readall', [App\Http\Controllers\BuyerNotificationController::class, 'readall'])->name('buyer_notification_readall');

});
