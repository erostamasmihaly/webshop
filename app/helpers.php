<?php

use App\Models\Cart;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
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

// Kategóriacsoport esetén a névből az ID meghatározása
if (!function_exists('get_category_group_id')) {
    function get_category_group_id($name) {
        return CategoryGroup::where('name',$name)->first()->id;
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
        $file_main_thumb = $dir.'/thumb/main_image.jpg';

        // Megnézni, hogy van-e vezérkép fájl - ha igen, akkor törlés
        if (File::exists($file_main)) {
            File::delete($file_main);
        }

        if (File::exists($file_main_thumb)) {
            File::delete($file_main_thumb);
        }
        
        // Vezérkép létrehozása
        $imageMod = ImageMod::make($file);            
        $imageMod->resize(800, 600, function ($const) {
            $const->aspectRatio();
        })->save($file_main);

        // Vezérkép létrehozása - kicsi
        $imageMod = ImageMod::make($file);            
        $imageMod->resize(200, 200, function ($const) {
            $const->aspectRatio();
        })->save($file_main_thumb);

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

        // Fizetendő összeg meghatározása
        $total = 0;

        // Végigmenni a kosár minden egyes elemén
        foreach ($carts AS $cart) {

            // Elemhez tartozó termék lekérdezése
            $product = Cart::find($cart->id)->product;

            // Termékhez tartozó mértékegység lekérdezése
            $unit = Product::find($product->id)->unit;

            // Mértékegység adatainak lekérdezése
            $unit = ProductCategory::find($unit->id)->category;

            // Méret adatainak lekérdezése
            $size = Category::find($cart->size_id);

            // Elem kiegészítése a termék és a mértékegység nevével
            $cart->product_name = $product->name;
            $cart->unit_name = $unit->name;
            $cart->size_name = $size->name;

            // További árak meghatározása
            $cart->brutto_price = product_prices($cart->product_id, $cart->size_id)["brutto"];
            $cart->discount_price = product_prices($cart->product_id, $cart->size_id)["discount"];
            $cart->discount_ft = product_prices($cart->product_id, $cart->size_id)["discount_ft"];
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

        $elements = User::find(Auth::id())->payed;
        foreach ($elements AS $element) {

            // Elemhez tartozó termék lekérdezése
            $product = Cart::find($element->id)->product;

            // Termékhez tartozó mértékegység lekérdezése
            $unit = Product::find($product->id)->unit;

            // Mértékegység adatainak lekérdezése
            $unit = ProductCategory::find($unit->id)->category;

            // Méret adatainak lekérdezése
            $size = Category::find($element->size_id);

            // Elemhez tratozó fizetés
            $payment = Cart::find($element->id)->payment;

            // Elem kiegészítése a termék és a mértékegység nevével, valamint a tranzakció számmal
            $element->product_name = $product->name;
            $element->unit_name = $unit->name;
            $element->size_name = $size->name;
            $element->transaction_id = $payment->transaction_id;

            // Ár meghatározása
            $element->price_ft = numformat_with_unit($element->price,'Ft');
        }

        // Visszatérés a tömbbel
        return $elements;

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
    function product_prices($id, $size_id = null) {

        // Termék
        $product = Product::find($id);

        // Megnézni, hogy van-e méret megadva
        if ($size_id==null) {

            // Ha nem, akkor a legnagyobb nettó ár alkalmazása
            $product_price = ProductPrice::where('product_id', $id)->orderBy('price','desc')->first();
        } else {

            // Ha igen, akkor az adott mérethez tartozó ár alkalmazása
            $product_price = ProductPrice::where('product_id', $id)->where('size_id', $size_id)->first();
        }

        // Árak meghatározása
        $netto_price = $product_price->price;
        $brutto_price = brutto_price($product_price->price, $product_price->vat);
        $discount_price = discount_price($brutto_price, $product_price->discount);

        // Ezen árak elmentése egy tömbbe
        $array['netto'] = $netto_price;
        $array['brutto'] = $brutto_price;
        $array['discount'] = $discount_price; 

        $array['netto_ft'] = numformat_with_unit($netto_price, 'Ft / '.$product->unit->category->name);
        $array['brutto_ft'] = numformat_with_unit($brutto_price, 'Ft / '.$product->unit->category->name);
        $array['discount_ft'] = numformat_with_unit($discount_price, 'Ft / '.$product->unit->category->name);

        // Visszatérés ezzel a tömbbel
        return $array;
    }
}

// Termékek lekérdezése
if (!function_exists('get_products')) {
    function get_products($groups, $all, $array = null, $limit = null, $page = null) {

        // Szűrők lekérdezése
        $shops = empty($array["shops"]) ? null : $array["shops"];
        $sizes = empty($array["sizes"]) ? null : $array["sizes"];
        $genders = empty($array["genders"]) ? null : $array["genders"];
        $ages = empty($array["ages"]) ? null : $array["ages"];

        // Gyűjtemény készítése
        $collection = collect();

        // Összes aktív termék lekérdezése
        $products = Product::where('active', 1)->get();

        // Végigmenni minden egyes terméken
        foreach($products AS $product) {

            // Objektum létrehozása
            $object = new stdClass();

            if ($all) {

                //// Ha minden információ kell
                // Objektum kapjon meg mindent a terméktől
                $object = $product;

            } else {

                //// Ha csak nagyon alap adatok kellenek (Főoldal számára)
                // Néhány termék tulajdonság hozzárendelése ehhez az objektumhoz
                $object->id = $product->id;
                $object->name = $product->name;
                $object->discount = $product->discount;
                $object->group_id = $product->group->category->id;
                $object->age_id = $product->age->category->id;
                $object->gender_id = $product->gender->category->id;
                $object->sizes = $product->sizes();
            }

            // Termék megtartása
            $keep = TRUE;

            // Termékcsoportra történő szűrés
            if (($groups != null) && (!in_array($product->group->category->id,$groups))) {
                $keep = FALSE;
            }    

            // Méretre történő szűrés
            if (($sizes != null) && (count(array_intersect($product->sizes()->toArray(),$sizes)))==0) {
                $keep = FALSE;
            }  

            // Nemre történő szűrés
            if (($genders != null) && (!in_array($product->gender->category->id,$genders))) {
                $keep = FALSE;
            }  

            // Korosztályra történő szűrés
            if (($ages != null) && (!in_array($product->age->category->id,$ages))) {
                $keep = FALSE;
            }  

            // Boltra történő szűrés
            if (($shops != null) && (!in_array($product->shop->id,$shops))) {
                $keep = FALSE;
            }     
            
            // Ha meg kell tartani
            if ($keep) {

                // Bruttó és kedvezményes árak behelyezése
                $object->brutto_price = product_prices($product->id)["brutto_ft"];
                $object->discount_price = product_prices($product->id)["discount_ft"];

                // Vezérkép elérhetősége
                $dir = public_path('images/products/'.$product->id);
                $file_main = $dir.'/main_image.jpg';

                // Megnézni, hogy van-e vezérkép fájl
                if (File::exists($file_main)) {

                    // Ha van, akkor annak a behelyezése
                    $object->image = 'images/products/'.$product->id.'/thumb/main_image.jpg';
                } else {

                    // Ha nincs, akkor a nincs kép fájl alkalmazása
                    $object->image = 'images/noimage.png';

                }

                // Termék behelyezése a gyűjteménybe
                $collection->push($object);
            } 
        }

        // Ha lapozni is kell
        if ($limit!=null && $page!=null) {
            $collection = $collection->skip($limit*$page)->take($limit)->values();
        }

        // Visszatérés ezen gyűjteménnyel
        return $collection;
    }
}

// Értékelések lekérdezése
if (!function_exists('get_ratings')) {
    function get_ratings($product_id, $moderated = true) {

        // Válasz tömb létrehozása
        $result = [];

        // Termék lekérdezése
        $product = Product::find($product_id);
        
        // Termék értékeléseinek lekérdezése, attól függően, hogy mindegyik kell, vagy csak a moderáltak
        if ($moderated) {
            $ratings = $product->ratingsModerated;
        } else {
            $ratings = $product->ratingsAll;
        }

        // További módosítások végzése
        foreach($ratings AS $rating) {

            // Értékeléshez tartozó felhasználó lekérdezése
            $user = Rating::find($rating->id)->user;

            // Ezen felhasználó adatainak felvitele az értékeléshez
            $rating->user_name = $user->name;

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
if (!function_exists('get_group_children')) {
    function get_group_children($categories) {

        // Ha null, akkor minden egyes szülő nélküli elem lekérdezése
        if ($categories==null) {
            $categories = Category::where('category_group_id',get_category_group_id('Termékcsoportok'))->whereNull('category_id')->pluck('id')->toArray();
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
            return get_group_children($return);
        }
    }
}

// Csak a dátum mutatása
if (!function_exists('show_date')) {
    function show_date($datetime) {
        return date("Y.m.d.",strtotime($datetime));
    }
}