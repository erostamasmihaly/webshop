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
// Bemeneti érték: 
//      $role_name: Szerepkör neve
// Kimeneti érték: 
//      TRUE, ha az éppen bejelentkezett felhasználóhoz az adott szerepkör is hozzá van rendelve
//      FALSE, ha vagy nincs hozzárendelve a szerepkör, vagy nincs bejelentkezve
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
// Bemenet: 
//      $role_name: Szerepkör neve
// Kimenet: 
//      403-as hiba akkor, ha az éppen bejelentkezett felhasználóhoz nincs hozzárendelve a megadott szerepkör vagy még nincs bejelentkezve
//      Semmi nem történik akkor, ha a bejelentkezett felhasználó rendelkezik az megadott szerepkörrel
if (!function_exists('restrict_role')) {
    function restrict_role($role_name) {

        // Ha nincs az adott szerepköre, akkor 403-as hiba
        if (!has_role($role_name)) {
            abort(403);
        }
    }
}

// Kategória ID esetén a név meghatározása
// Bemenet: 
//      $category_id: Kategória azonosítója
// Kimenet: Kategória neve
if (!function_exists('get_category_name')) {
    function get_category_name($category_id) {
        return Category::find($category_id)->name;
    }
}

// Kategóriacsoport esetén a névből az ID meghatározása
// Bemenet: 
//      $category_group_name: Kategóriacsoport neve
// Kimenet: Kategóriacsoport azonosítója
if (!function_exists('get_category_group_id')) {
    function get_category_group_id($category_group_name) {
        return CategoryGroup::where('name',$category_group_name)->first()->id;
    }   
}

// Számformátum mértékegységgel
// Bemenet:
//      $number: Szám
//      $unit: Mértékegység
// Kimenet: Magyarországon használt számformátum, a végén az opcionális mértékegységgel
if (!function_exists('numformat_with_unit')) {
    function numformat_with_unit($number, $unit = "") {
        return trim(number_format($number, 0, ',', ' ').' '.$unit);
    }
}

// Vezérkép létrehozása
// Bemenet:
//      $product_id: Termék azonosítója
//      $image_file_name: Azon kép, amelyből a vezérképet létre akarjuk hozni
// Kimenet: Vezérkép két méretben, amely képek a megadott kép átméretezett másolatai
if (!function_exists('create_main_image')) {
    function create_main_image($product_id, $image_file_name) {

        // Könyvtár
        $dir = public_path('images/products/'.$product_id);
        $dir_exists = is_dir($dir);
        if (!$dir_exists) {
            mkdir($dir, 0777, true);
        }

        // Fájlok megadása
        $file = $dir.'/'.$image_file_name;
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
// Bemenet:
//      $price: Ár
//      $vat: ÁFA
// Kimenet: Bruttó ár, ami a bemeneti értékekből számolódik ki
if (!function_exists('brutto_price')) {
    function brutto_price($price, $vat) {
        return (int)($price + ($price * ($vat / 100)));
    }
}

// Kedvezményes ár kiszámítása
// Bemenet:
//      $brutto: Bruttó ár
//      $discount: Kedvezmény nagysága
// Kimenet: Kedvezményes ár, ami a bemeneti értékekből számolódik ki
if (!function_exists('discount_price')) {
    function discount_price($brutto, $discount) {
        return (int)($brutto - ($brutto * ($discount / 100)));
    }
}

// Aktiváló kód létrehozása
// Bemenet: Nincsen
// Kimenet: Random azonosító MD5-ben HASH-elve
if (!function_exists('generate_activation_code')) {
    function generate_activation_code() {
        return md5(uniqid(mt_rand(), true));
    }
}

// Kosár lekérdezése
// Bemenet: Nincsen - az éppen bejelentkezett felhasználó kosara lesz mindig lekérdezve
// Kimenet: 
//      carts: Kosár azon tartalmai, amiket még nem fizetett ki
//      total: Kosárban lévő tartalmak árainak összege - formázatlanul
//      total_ft: Kosárban lévő tartalmak árainak összege - formázottan
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
            $cart->brutto_price = product_prices($cart->product_id, $cart->size_id)["brutto_price"];
            $cart->discount_price = product_prices($cart->product_id, $cart->size_id)["discount_price"];
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
// Bemenet: Nincsen - az éppen bejelentkezett felhasználó kosara lesz mindig lekérdezve
// Kimenet: Kosár azon tartalmai, amiket már kifizetett
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
// Bemenet: Nincsen - Mindig az aktuális felhasználó lesz figyelembe véve
// Kimenet: TRUE akkor, ha mindig fizetéshez szükséges személyes adatot megadott, különben pedig FALSE
if (!function_exists('can_pay')) {
    function can_pay() {
        return User::where('id', Auth::id())->whereNotNull(['country','state','zip','city','address'])->first();
    }
}

// Termék árainak lekérdezése
// Bemenet:
//      $product_id: Termék azonosítója
//      $size_id: Méret azonosítója
// Kimenet:
// - Ha van méret megadva, akkor az adott mérethez tartozó bruttó ár
// - Ha nincs méret megadva, akkor a legnagyobb nettó árhoz tartozó bruttó ár
if (!function_exists('product_prices')) {
    function product_prices($product_id, $size_id = null) {

        // Termék
        $product = Product::find($product_id);

        // Megnézni, hogy van-e méret megadva
        if ($size_id==null) {

            // Ha nem, akkor a legnagyobb kedvezményes ár alkalmazása
            $product_price = ProductPrice::where('product_id', $product_id)->orderBy('discount_price','desc')->first();
        } else {

            // Ha igen, akkor az adott mérethez tartozó ár alkalmazása
            $product_price = ProductPrice::where('product_id', $product_id)->where('size_id', $size_id)->first();
        }

        if ($product_price) {

            // Ezen árak lekérdezése és elmentése egy tömbbe
            $array['vat'] = $product_price->vat;
            $array['discount'] = $product_price->discount;
            $array['netto_price'] = $product_price->price;
            $array['brutto_price'] = $product_price->brutto_price;
            $array['discount_price'] = $product_price->discount_price;
        } else {

            // Üres árak elmentése egy tömbbe
            $array['vat'] = 0;
            $array['discount'] = 0;
            $array['netto_price'] = 0;
            $array['brutto_price'] = 0;
            $array['discount_price'] = 0;
            
        }

        // Árak forintban és megfelelően formázva
        $array['netto_ft'] = numformat_with_unit($array['netto_price'], 'Ft / ' . $product->unit->category->name);
        $array['brutto_ft'] = numformat_with_unit($array['brutto_price'], 'Ft / ' . $product->unit->category->name);
        $array['discount_ft'] = numformat_with_unit($array['discount_price'], 'Ft / ' . $product->unit->category->name);

        // Visszatérés ezzel a tömbbel
        return $array;
    }
}

// Termékek lekérdezése
// Bemenet:
//      $groups: Termékcsoportok tömbje
//      $more_info: Minden információt tartalmazzon a válasz, vagy csak a szükségeset
//      $filters: Egyéb szűrőket tartalmazó tömb
//      $limit: Mennyi elemnek kell egy oldal megjelennie
//      $page: Melyik oldal tartalmát kell mutatni
//      $only_active: Csak az aktív termékeket kell-e lekérdezni?
// Kimenet: Az adott feltételeknek megfelelő termékek
if (!function_exists('get_products')) {
    function get_products($groups, $more_info, $filters = null, $limit = null, $page = null, $only_active = true) {

        // Szűrők lekérdezése
        $shops = empty($filters["shops"]) ? null : $filters["shops"];
        $sizes = empty($filters["sizes"]) ? null : $filters["sizes"];
        $genders = empty($filters["genders"]) ? null : $filters["genders"];
        $ages = empty($filters["ages"]) ? null : $filters["ages"];

        // Gyűjtemény készítése
        $collection = collect();

        // Összes termék lekérdezése, függően attól, hogy mindenre vagy csak aktívakra van-e szükség
        if ($only_active) {
            $products = Product::where('active', 1)->get();
        } else {
            $products = Product::get();
        }
        

        // Végigmenni minden egyes terméken
        foreach($products AS $product) {

            // Objektum létrehozása
            $object = new stdClass();

            if ($more_info) {

                //// Ha minden információ kell
                // Objektum kapjon meg mindent a terméktől
                $object = $product;

            } else {

                //// Ha csak nagyon alap adatok kellenek (Főoldal számára)
                // Néhány termék tulajdonság hozzárendelése ehhez az objektumhoz
                $object->id = $product->id;
                $object->name = $product->name;
                $object->active = $product->active;
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
                    $object->image = asset('images/products/'.$product->id.'/thumb/main_image.jpg');
                } else {

                    // Ha nincs, akkor a nincs kép fájl alkalmazása
                    $object->image = asset('images/noimage.png');

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
// Bemenet:
//      $product_id: Termék azonosítója
//      $moderated: Csak a moderáltakat kell-e lekérdezni?
// Kimenet: 
//      ratings: Egy termékhez tartozó összes vagy moderált értékelések
//      stars: Minden egyes csillagértékhez tartozó elemszám*
//      total: Összes eddigi értékelés száma*
// * csak a moderált értékelések lesznek figyelembe véve, mert ezek már publikus adatok
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

// OrderRef generálása
// Bemenet: Nincsen
// Kimenet: Egy olyan azonosító, ami nagy valószínűséggel az OTP Simple rendszerben sem található -- IP-cím, dátumidő és random számokból állítódik össze, ami az OTP javaslata
if (!function_exists('generate_order_ref')) {
    function generate_order_ref() {
        return str_replace(array('.', ':', '/'), '', @$_SERVER['SERVER_ADDR']) . @date('U', time()) . rand(1000, 9999);
    }
}

// Kategória szülők lekérdezése
// Bemenet:
//      $category_id: Kategória azonosító
//      $array: Egy tömb, ami a rekurziók eredményét tartalmazza
// Kimenet: Minden olyan kategória azonosító, ami a megadott kategória elődei 
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

// Lekérdezni a kategória gyerekei
// Bemenet:
//      $categories: Olyan kategóriák tömbje, amiknek a gyerekeire szükségünk van - minden egyes rekurzió során bővül
// Kimenet: A megadott kategóriák gyerekei
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
// Bemenet:
//      $datetime: Dátumidő érték
// Kimenet: ÉÉÉÉ.HH.NN. formátumban a megadott dátum
if (!function_exists('show_date')) {
    function show_date($datetime) {
        return date("Y.m.d.",strtotime($datetime));
    }
}

// Ha szükséges, akkor kettészedni a kosárban lévő bejegyzést a fizetés előtt, ha esetleg több lenne a kosárba, mint amit éppen lehet megvásárolni
// Bemenet:
//      $cart: Kosár bejegyzés, amit esetleg ketté kell szedni
// Kimenet: Azon mennyiség, amennyit a vásárló akar a termékből megvenni, de nem nagyobb, mint amennyit ténylegesen meg lehet venni belőle
if (!function_exists('cart_quantity_split')) {
    function cart_quantity_split($cart) {

        // Megvett termék méretének lekérdezése
        $size_id = $cart->size_id;

        // Adott mérethez tartozó maximális megvehető mennyiség lekérdezése
        $max_quantity = $cart->product->prices->where('size_id',$size_id)->first()->quantity;
        
        // Megvásárolni kívánt mennyiség lekérdezése
        $cart_quantity = $cart->quantity;

        // Megnézni, hogy többet akar-e megvenni, mint amennyi elérhető
        if ($cart_quantity <= $max_quantity) {

            //// Ha nem
            // Visszatérni azon mennyiséggel, amelyet eleve meg akart vásárolni
            return $cart_quantity;
        } else {

            //// Ha igen
            // Meghatározni, hogy mennyi nem vehet meg 
            $new_quantity = $cart_quantity - $max_quantity;

            // Egy hasonló kosárbejegyzés létrehozása, ami ezen épp meg nem vehető mennyiséget
            $new_cart = new Cart();
            $new_cart->user_id = $cart->user_id;
            $new_cart->product_id = $cart->product_id;
            $new_cart->size_id = $cart->size_id;
            $new_cart->quantity = $new_quantity;
            $new_cart->save();

            // Az eredeti kosárban a mennyiség csökkentése a jelenleg elérhető maximálisra
            $cart->quantity = $max_quantity;
            $cart->save();

            // Visszatérni ezen maximális értékkel
            return $max_quantity;
        }
    }
}

// Sikertelen fizetés esetén újra egyesíteni a kettészedett kosár bejegyzést
// Bemenet:
//      $cart: Kosár bejegyzés, ami ketté lett szedve
if (!function_exists('cart_quantity_join')) {
    function cart_quantity_join($cart) {

        // Ha még létezik a kosár
        if ($cart) {

            // Megnézni, hogy van-e olyan kosár, ami ennek a szétszedésével jött létre
            $other_cart = Cart::where('id','!=',$cart->id)->where('user_id', $cart->user_id)->where('product_id',$cart->product_id)->where('size_id', $cart->size_id)->whereNull('payment_id')->first();

            // Ha van
            if ($other_cart) {

                // Eredeti kosárban lévő mennyiség visszakerül az újból
                $cart->quantity = $cart->quantity + $other_cart->quantity;
                $cart->save();

                // Ezen utóbbi kosár pedig törlésre kerül
                $other_cart->delete();
            }
        }

       
    }
}