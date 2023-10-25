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

});