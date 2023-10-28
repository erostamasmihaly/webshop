<?php

use App\Http\Middleware\BuyerMiddleware;
use Illuminate\Support\Facades\Route;

// Vue oldalak
Route::group(['prefix' => 'vue'], function() {

    Route::get('/{vue_capture?}', function() {
        return view('buyer.vue');
    })->where('vue_capture', '[\/\w\.-]*')->name('vue')->middleware(BuyerMiddleware::class);

});

// Vue oldalak
Route::group(['prefix' => 'api/vue'], function() {

    // Felhasználó lekérdezése
    Route::get('user', [App\Http\Controllers\VueApiController::class, 'get_user'])->name('vue_get_user');

    // Felhasználó mentése
    Route::post('user', [App\Http\Controllers\VueApiController::class, 'post_user'])->name('vue_post_user');

    // Eddigi vásárlások lekérdezése
    Route::get('payed', [App\Http\Controllers\VueApiController::class, 'get_payed'])->name('vue_get_payed');

    // Kosár tartalma
    Route::get('cart', [App\Http\Controllers\VueApiController::class, 'get_cart'])->name('vue_get_cart');

    // Kosár elem módosítása
    Route::post('cart', [App\Http\Controllers\VueApiController::class, 'post_cart'])->name('vue_post_cart');

    // Termék adatai
    Route::get('product/{id}', [App\Http\Controllers\VueApiController::class, 'get_product'])->name('vue_get_product');

    // Értékelés lekérdezése
    Route::get('rating/{id}', [App\Http\Controllers\VueApiController::class, 'get_rating'])->name('vue_get_rating');

    // Értékelés felvitele
    Route::put('rating', [App\Http\Controllers\VueApiController::class, 'put_rating'])->name('vue_put_rating');

    // Termékek lekérdezése
    Route::get('list', [App\Http\Controllers\VueApiController::class, 'get_list'])->name('vue_get_list');

    // Kosár elem felvitele
    Route::put('cart', [App\Http\Controllers\VueApiController::class, 'put_cart'])->name('vue_put_cart');

    // Értesítések lekérdezése
    Route::get('notification', [App\Http\Controllers\VueApiController::class, 'get_notification'])->name('vue_get_notification');

    // Értesítés olvasottnak jelölése - Egy megadott
    Route::post('notification/one', [App\Http\Controllers\VueApiController::class, 'post_notification_one'])->name('vue_post_notification_one');

    // Értesítés olvasottnak jelölése - Összes
    Route::post('notification/all', [App\Http\Controllers\VueApiController::class, 'post_notification_all'])->name('vue_post_notification_all');

});