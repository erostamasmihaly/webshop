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

    // Hozzáadás a kosár elemhez
    Route::post('cart/add', [App\Http\Controllers\VueApiController::class, 'add_cart'])->name('vue_add_cart');

    // Elvétel a kosár elemből
    Route::post('cart/remove', [App\Http\Controllers\VueApiController::class, 'remove_cart'])->name('vue_remove_cart');

    // Kosár elem törlése
    Route::post('cart/delete', [App\Http\Controllers\VueApiController::class, 'delete_cart'])->name('vue_delete_cart');

});