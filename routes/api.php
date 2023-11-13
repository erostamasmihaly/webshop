<?php

use Illuminate\Support\Facades\Route;

// Felhasználó lekérdezése
Route::get('user', [App\Http\Controllers\ApiController::class, 'get_user']);

// Felhasználó mentése
Route::post('user', [App\Http\Controllers\ApiController::class, 'post_user']);

// Eddigi vásárlások lekérdezése
Route::get('payed', [App\Http\Controllers\ApiController::class, 'get_payed']);

// Kosár tartalma
Route::get('cart', [App\Http\Controllers\ApiController::class, 'get_cart']);

// Kosár elem módosítása
Route::post('cart', [App\Http\Controllers\ApiController::class, 'post_cart']);

// Termék adatai
Route::get('product/{id}', [App\Http\Controllers\ApiController::class, 'get_product']);

// Értékelés lekérdezése
Route::get('rating/{id}', [App\Http\Controllers\ApiController::class, 'get_rating']);

// Értékelés fényképeinek lekérdezése
Route::get('rating/{id}/images', [App\Http\Controllers\ApiController::class, 'get_rating_images']);

// Értékelés felvitele
Route::put('rating', [App\Http\Controllers\ApiController::class, 'put_rating']);

// Értékelés felvitele
Route::post('rating', [App\Http\Controllers\ApiController::class, 'post_rating']);

// Termékek lekérdezése
Route::get('list', [App\Http\Controllers\ApiController::class, 'get_list']);

// Kosár elem felvitele
Route::put('cart', [App\Http\Controllers\ApiController::class, 'put_cart']);

// Értesítések lekérdezése
Route::get('notification', [App\Http\Controllers\ApiController::class, 'get_notification']);

// Értesítés olvasottnak jelölése - Egy megadott
Route::post('notification/one', [App\Http\Controllers\ApiController::class, 'post_notification_one']);

// Értesítés olvasottnak jelölése - Összes
Route::post('notification/all', [App\Http\Controllers\ApiController::class, 'post_notification_all']);

// Kedvelés lekérdezése
Route::get('favourite/{id}', [App\Http\Controllers\ApiController::class, 'get_favourite']);

// Kedvelés módosítása
Route::post('favourite', [App\Http\Controllers\ApiController::class, 'post_favourite']);