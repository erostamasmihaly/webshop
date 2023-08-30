<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Bejelentkezés oldal
Auth::routes(['register' => false, 'reset' => false]);

//// Vásárlói szerepkör

// Index
require 'buyer/index.php';

// Kosár
require 'buyer/cart.php';

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

// Termékek
require 'seller/product.php';
