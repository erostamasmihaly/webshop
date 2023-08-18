<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Fő oldal
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Bejelentkezés oldalai
Auth::routes();

//// Admin szerepkör

// Vezérlőpult
require 'admin/index.php';

// Felhasználók
require 'admin/user.php';

// Kategóriák
require 'admin/category.php';

// Üzletek
require 'admin/shop.php';
