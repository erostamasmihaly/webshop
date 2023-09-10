<?php

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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

// Vezérkép létrehozása
if (!function_exists('create_main_image')) {
    function create_main_image($product_id, $image) {

        // Könyvtár
        $dir = public_path('images/products/'.$product_id);
        $dir_exists = is_dir($dir);
        if (!$dir_exists) {
            mkdir($dir, 0777, true);
        }

        // Fájlok megadása
        $file = $dir.'/'.$image;
        $file_main = $dir.'/main_image.jpg';

        // Megnézni, hogy van-e vezérkép fájl - ha igen, akkor törlés
        if (File::exists($file_main)) {
            File::delete($file_main);
        }
        
        // Vezérkép létrehozása
        $imageMod = ImageMod::make($file);            
        $imageMod->resize(800, 600, function ($const) {
            $const->aspectRatio();
        })->save($file_main);

    }
}

// Bruttó ár kiszámítása
if (!function_exists('brutto_price')) {
    function brutto_price($price, $vat) {
        return (int)($price + ($price * ($vat / 100)));
    }
}

// Kedvezményes ár kiszámítása
if (!function_exists('discount_price')) {
    function discount_price($brutto, $discount) {
        return (int)($brutto - ($brutto * ($discount / 100)));
    }
}

// Aktiváló kód létrehozása
if (!function_exists('get_activtion_code')) {
    function get_activation_code() {
        return md5(uniqid(mt_rand(), true));
    }
}

// Kosár lekérdezése
if (!function_exists('get_cart')) {
    function get_cart() {

        // Kosár lekérdezése
        $carts = Cart::join('products','carts.product_id','products.id')->join('units','products.unit_id','units.id')->where('user_id', Auth::id())->whereNull('payment_id')->get(['products.id','products.name','carts.quantity','units.name AS unit','carts.id AS cart_id']);

        // Fizetendő összeg meghatározása
        $total = 0;

        // További árak meghatározása
        foreach($carts AS $cart) {
            $cart->brutto_price = product_prices($cart->id)["brutto"];
            $cart->discount_price = product_prices($cart->id)["discount"];
            $cart->discount_ft = product_prices($cart->id)["discount_ft"];
            $total += $cart->discount_price * $cart->quantity;
        }

        // Tömbbe behelyezni az értékeket
        $array["carts"] = $carts;
        $array["total"] = $total;
        $array["total_ft"] = numformat_with_unit($total,'Ft');

        // Visszatérés a tömbbel
        return $array;

    }
}

// Kifizetett termékek lekérdezése
if (!function_exists('get_pay_history')) {
    function get_pay_history() {

        // Kosár lekérdezése
        $carts = Cart::join('products','carts.product_id','products.id')->join('units','products.unit_id','units.id')->join('payments','carts.payment_id','payments.id')->where('carts.user_id', Auth::id())->whereNotNull('payment_id')->orderBy('payments.updated_at','desc')->get(['products.id','products.name','carts.quantity','units.name AS unit','carts.id AS cart_id','payments.transaction_id','carts.price','payments.updated_at']);

        // További árak meghatározása
        foreach($carts AS $cart) {
            $cart->price_ft = numformat_with_unit($cart->price,'Ft');;
        }

        // Visszatérés a tömbbel
        return $carts;

    }
}

// Tud fizetni a felhasználó - vagyis megvan minden adata ahhoz, hogy fizessen?
if (!function_exists('can_pay')) {
    function can_pay() {
        return User::where('id', Auth::id())->whereNotNull(['country','state','zip','city','address'])->first();
    }
}

// Termék árainak lekérdezése
if (!function_exists('product_prices')) {
    function product_prices($id) {

        // Termék kikeresése
        $product = Product::where('products.id', $id)->join('units','products.unit_id','units.id')->get(['products.*','units.name AS unit'])->first();

        // Árak meghatározása
        $brutto_price = brutto_price($product->price, $product->vat);
        $discount_price = discount_price($brutto_price, $product->discount);

        // Ezen árak elmentése egy tömbbe
        $array['brutto'] = $brutto_price;
        $array['discount'] = $discount_price; 
        $array['brutto_ft'] = numformat_with_unit($brutto_price, 'Ft / '.$product->unit);
        $array['discount_ft'] = numformat_with_unit($discount_price, 'Ft / '.$product->unit);

        // Visszatérés ezzel a tömbel
        return $array;
    }
}

// Termékek lekérdezése
if (!function_exists('get_products')) {
    function get_products($shop_id = null) {

        // Összes termék lekérdezése
        $products = Product::join('shops','products.shop_id','shops.id')->join('units','products.unit_id','units.id')->join('categories','products.category_id','categories.id')->where(function($query) {return $query->where('active', 1)->orWhere('quantity', '>', 0);});

        // Ha megvan adva a bolt azonosítója, akkor ezen azonosítóra történő szűrés
        if ($shop_id != null) {
            $products = $products->whereIn('shop_id', $shop_id);
        }
        
        // Adatok lekérdezése
        $products = $products->get(['products.id','products.name','products.summary','shops.name AS shop','units.name AS unit','products.discount','products.category_id','categories.name AS category','products.quantity']);

        // Bruttó és kedvezményes árak behelyezése
        foreach($products AS $product) {
            $product->brutto_price = product_prices($product->id)["brutto_ft"];
            $product->discount_price = product_prices($product->id)["discount_ft"];
        }

        // Visszatérés ezen termékekkel
        return $products;
    }
}

// Értékelések lekérdezése
if (!function_exists('get_ratings')) {
    function get_ratings($product_id, $moderated = true) {

        // Válasz tömb létrehozása
        $result = [];
        
        // Értékelések lekérdezése
        $ratings = Rating::join('users','ratings.user_id','users.id')->where('ratings.product_id', $product_id);
        
        // Ha csak a moderáltak legyenek benne
        if ($moderated) {
            $ratings = $ratings->where('ratings.moderated', 1);
        }
        
        // Sorrend és mezők megadása
        $ratings = $ratings->orderBy('ratings.updated_at','desc')->get(['users.id AS user_id','users.name AS user_name','ratings.id AS rating_id','ratings.title','ratings.body','ratings.stars','ratings.updated_at','ratings.moderated']);

        // Dátumformátum
        foreach($ratings AS $rating) {
            $rating->updated = date("Y-m-d H:i", strtotime($rating->updated_at));
        }

        // Csillagonkénti statisztika
        $stars = Rating::where('product_id', $product_id)->where('moderated',1)->groupBy('stars')->orderBy('stars','desc')->get(['stars', DB::raw('COUNT(*) AS total')]);

        // Összes statisztika
        $total = Rating::where('product_id', $product_id)->where('moderated',1)->get([DB::raw('AVG(stars) AS stars'), DB::raw('COUNT(*) AS total')]);

        // Választömb létrehozása
        $result["ratings"] = $ratings;
        $result["stars"] = $stars;
        $result["total"] = $total;

        // Visszatérés ezen értékelésekkel
        return $result;
    }
}

// Kategória szülők lekérdezése
if (!function_exists('get_category_parents')) {
    function get_category_parents($category_id, $array = []) {

        // Szülő lekérdezése
        $parent_id = Category::find($category_id)->category_id;
        if ($parent_id == NULL) {

            // Ha nincs szülő, akkor visszatérni a tömbbel
            return $array;
            
        } else {

            //// Ha van szülő

            // Szülő behelyezése a tömbbe
            $array[] = $parent_id;

            // Rekurzív meghívás a szülővel és a tömbbrl
            return get_category_parents($parent_id, $array);
        }
    }
}