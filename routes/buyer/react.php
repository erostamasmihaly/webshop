<?php

use App\Http\Middleware\BuyerMiddleware;
use Illuminate\Support\Facades\Route;

// Vue oldalak
Route::group(['prefix' => 'react'], function() {

    Route::get('/', function() {
        return view('buyer.react.main');
    })->name('react')->middleware(BuyerMiddleware::class);

    Route::get('payed', function() {
        return view('buyer.react.payed');
    })->middleware(BuyerMiddleware::class);

    Route::get('list', function() {
        return view('buyer.react.list');
    })->middleware(BuyerMiddleware::class);

    Route::get('user', function() {
        return view('buyer.react.user');
    })->middleware(BuyerMiddleware::class);

});