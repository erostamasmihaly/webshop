<?php

use Illuminate\Support\Facades\Route;

// Üzletek
Route::group(['prefix' => 'seller/shop'], function() {

    // Üzletek listája
    Route::get('', [App\Http\Controllers\SellerShopController::class, 'index'])->name('seller_shop');

    // Üzlet kifizetett kosarai 
    Route::get('{id}/payed_carts', [App\Http\Controllers\SellerShopController::class, 'payed_carts'])->name('seller_shop_payed_carts');

});