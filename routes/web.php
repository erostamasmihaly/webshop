<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Bejelentkezés oldal
Auth::routes(['register' => false, 'reset' => false]);

//// Teszt
Route::get('test', [App\Http\Controllers\TestController::class, 'index'])->name('test_index');

//// Vásárlói szerepkör

// Publikus
require 'buyer/public.php';

// Védett
require 'buyer/protected.php';

// Fizetés
require 'buyer/pay.php';

// Vue
require 'buyer/vue.php';

//// Admin szerepkör

// Vezérlőpult
require 'admin/index.php';

// Felhasználók
require 'admin/user.php';

// Kategóriák
require 'admin/category.php';

// Üzletek
require 'admin/shop.php';

//// Alkalmazotti szerepkör

// Vezérlőpult
require 'seller/index.php';

// Értesítések
require 'seller/notification.php';

// Termékek
require 'seller/product.php';

// Munkakörök
require 'seller/position.php';

// Üzletek
require 'seller/shop.php';
