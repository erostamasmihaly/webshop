<?php

use App\Http\Middleware\BuyerMiddleware;
use Illuminate\Support\Facades\Route;

// Vue oldalak
Route::group(['prefix' => 'react'], function() {

    Route::get('/', function() {
        return view('buyer.react');
    })->name('react')->middleware(BuyerMiddleware::class);

});