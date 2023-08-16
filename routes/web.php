<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin felület
Route::group([ 'prefix' => 'admin' ], function() {

    // Vezérlőpult
    Route::get('index', [App\Http\Controllers\AdminIndexController::class, 'index'])->name('admin_index');

});
