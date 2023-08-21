<?php

use App\Models\Category;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

// Megnézni, hogy az adott szerepkörrel rendelkezik-e a felhasználó
if (!function_exists('has_role')) {
    function has_role($role_name) {

        // Ha be van jelentkezve a felhasználó
        if (Auth::user()) {

            // Adott szerepkör ID lekérdezése
            $role_id = Role::where("name", $role_name)->first()->id;
             
            // Megnézni, hogy van-e az adott szerepköre a felhasználónak és ezzel térni vissza, mint válasz
            return UserRole::where("user_id", Auth::id())->where("role_id", $role_id)->first();
            
        } else {

            // Ha nincs bejelentkezve, akkor FALSE
            return false;
        }
    }
}

// Ha az adott szerepkörrel nem rendelkezik a felhasználó, akkor 403-as hiba
if (!function_exists('restrict_role')) {
    function restrict_role($role_name) {

        // Ha nincs az adott szerepköre, akkor 403-as hiba
        if (!has_role($role_name)) {
            abort(403);
        }
    }
}

// Kategória ID esetén a név meghatározása
if (!function_exists('get_category_name')) {
    function get_category_name($category_id) {
        return Category::find($category_id)->name;
    }
}

// Számformátum mértékegységgel
if (!function_exists('numformat_with_unit')) {
    function numformat_with_unit($number, $unit = "") {
        return trim(number_format($number, 0, ',', ' ').' '.$unit);
    }
}