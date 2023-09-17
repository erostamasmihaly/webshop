<?php

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
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
if (!function_exists('generate_activation_code')) {
    function generate_activation_code() {
        return md5(uniqid(mt_rand(), true));
    }
}

// Kosár lekérdezése
if (!function_exists('get_cart')) {
    function get_cart() {

        // Kosár lekérdezése
        $carts = User::find(Auth::id())->carts;

        // Végigmenni a kosár minden egyes elemén
        foreach ($carts AS $cart) {

            // Elemhez tartozó termék lekérdezése
            $product = Cart::find($cart->id)->product;

            // Termékhez tartozó mértékegység lekérdezése
            $product_unit = Product::find($product->id)->product_unit;

            // Mértékegység adatainak lekérdezése
            $unit = ProductCategory::find($product_unit->id)->category;

            // Elem kiegészítése a termék és a mértékegység nevével
            $cart->product_name = $product->name;
            $cart->unit_name = $unit->name;
        }

        // Fizetendő összeg meghatározása
        $total = 0;

        // További árak meghatározása
        foreach($carts AS $cart) {
            $cart->brutto_price = product_prices($cart->product_id)["brutto"];
            $cart->discount_price = product_prices($cart->product_id)["discount"];
            $cart->discount_ft = product_prices($cart->product_id)["discount_ft"];
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
        $carts = Cart::join('products','carts.product_id','products.id')->join('categories AS units','products.unit_id','units.id')->join('payments','carts.payment_id','payments.id')->where('carts.user_id', Auth::id())->whereNotNull('payment_id')->orderBy('payments.updated_at','desc')->get(['products.id','products.name','carts.quantity','units.name AS unit','carts.id AS cart_id','payments.transaction_id','carts.price','payments.updated_at']);

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
        $product = Product::where('products.id', $id)->join('product_categories','product_categories.product_id','products.id')->join('categories AS units','product_categories.category_id','units.id')->get(['products.*','units.name AS unit'])->first();

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
    function get_products($category_id = null, $shop_id = null) {

        // Összes termék lekérdezése
        $products = Product::join('shops','products.shop_id','shops.id')->join('product_categories','product_categories.product_id','products.id')->join('categories AS units','product_categories.category_id','units.id')->join('categories','product_categories.category_id','categories.id')->where(function($query) {return $query->where('active', 1)->orWhere('quantity', '>', 0);});

        // Ha meg van adva a kategória, akkor ezen kategóriára történő szűrés
        if ($category_id != null) {
            $products = $products->whereIn('categories.id', $category_id);
        }        

        // Ha meg van adva a bolt azonosítója, akkor ezen boltra történő szűrés
        if ($shop_id != null) {
            $products = $products->whereIn('products.shop_id', $shop_id);
        }
        
        // Adatok lekérdezése
        $products = $products->get(['products.id','products.name','products.summary','shops.name AS shop','units.name AS unit','products.discount','categories.id AS category_id','categories.name AS category','products.quantity']);

        // Végigmenni minden egyes terméken
        foreach($products AS $product) {

            // Bruttó és kedvezményes árak behelyezése
            $product->brutto_price = product_prices($product->id)["brutto_ft"];
            $product->discount_price = product_prices($product->id)["discount_ft"];

            // Vezérkép elérhetősége
            $dir = public_path('images/products/'.$product->id);
            $file_main = $dir.'/main_image.jpg';

            // Megnézni, hogy van-e vezérkép fájl
            if (File::exists($file_main)) {

                // Ha van, akkor annak a behelyezése
                $product->image = 'images/products/'.$product->id.'/main_image.jpg';
            } else {

                // Ha nincs, akkor a nincs kép fájl alkalmazása
                $product->image = 'images/noimage.png';

            }
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

        // További módosítások végzése
        foreach($ratings AS $rating) {

            // Dátumformátum
            $rating->updated = date("Y-m-d H:i", strtotime($rating->updated_at));

            // Üres string létrehozása
            $fa_stars = '';

            // Végigmenni 1-től 5-ig és addig legyen tömött csillag, ameddig kapta az értékelést
            for ($i=1; $i<=5; $i++) {
                if ($i<=$rating->stars) {
                    $fa_stars .= '<i class="fa-solid fa-star"></i>';
                } else {
                    $fa_stars .= '<i class="fa-regular fa-star"></i>';
                }
            }

            // Ezen csillagok behelyezése a válaszba
            $rating->fa_stars = $fa_stars;
        }

        // Csillagonkénti statisztika
        $stars = Rating::where('product_id', $product_id)->where('moderated',1)->groupBy('stars')->orderBy('stars','desc')->get(['stars', DB::raw('COUNT(*) AS total')]);

        // Összes statisztika
        $total = Rating::where('product_id', $product_id)->where('moderated',1)->get([DB::raw('ROUND(AVG(stars)) AS stars'), DB::raw('COUNT(*) AS total')]);

        // Üres string létrehozása
        $fa_stars = '';

        // Végigmenni 1-től 5-ig és addig legyen tömött csillag, ameddig kapta az értékelést
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $total->first()->stars) {
                $fa_stars .= '<i class="fa-solid fa-star"></i>';
            } else {
                $fa_stars .= '<i class="fa-regular fa-star"></i>';
            }
        }


        // Ezen csillagok behelyezése a válaszba
        $total->first()->fa_stars = $fa_stars;

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

// OrderRef generálása - OTP dokumentáció ajánlása, egy olyan azonosító, ami az OTP rendszerében is egyedi
if (!function_exists('generate_order_ref')) {
    function generate_order_ref() {
        return str_replace(array('.', ':', '/'), '', @$_SERVER['SERVER_ADDR']) . @date('U', time()) . rand(1000, 9999);
    }
}

// Lekérdezni a kategória gyerekei
if (!function_exists('get_category_children')) {
    function get_category_children($categories) {

        // Ha null, akkor minden egyes szülő nélküli elem lekérdezése
        if ($categories==null) {
            $categories = Category::where('category_group_id',1)->whereNull('category_id')->pluck('id')->toArray();
        }
        
        // Lekérdezni minden olyan elemet, ami a megadott kategóriák gyereke, kivéve olyat, ami már ezen kategóriák között megtalálható
        $children = Category::whereIn('category_id', $categories)->whereNotIn('id', $categories)->pluck('id')->toArray();

        // Válasz tömb létrehozása ezen két tömb összeolvadásával
        $return = array_values(array_unique(array_merge($categories, $children)));
        if (count($children) == 0) {
            
            // Ha nincs már gyerek, akkor visszatérés ezen tömbbel
            return $return;
        } else {

            // Ha van még gyerek, akkor a függvény rekurzív meghívása ezen válasz tömbbel 
            return get_category_children($return);
        }
    }
}