<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//// Admin szerepkör

// Vezérlőpult
require 'admin/index.php';

// Felhasználók
require 'admin/user.php';

// Kategóriák
require 'admin/category.php';
