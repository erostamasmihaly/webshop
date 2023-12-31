<?php

use App\Http\Middleware\BuyerMiddleware;
use Illuminate\Support\Facades\Route;

// Vue oldalak
Route::group(['prefix' => 'vue'], function() {

    Route::get('/{vue_capture?}', function() {
        return view('buyer.vue');
    })->where('vue_capture', '[\/\w\.-]*')->name('vue')->middleware(BuyerMiddleware::class);

});