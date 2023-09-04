<?php

namespace App\Http\Controllers;

use App\Http\Services\UserActivate;
use App\Http\Services\UserInsert;
use App\Mail\RegisterMail;
use App\Models\Favourite;
use App\Models\Image;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BuyerPublicController extends Controller
{

    public function __construct()
    { }

    // Fő oldal
    public function index()
    {

        // Felület betöltése
        return view('buyer.index', [
            'products' => get_products()
        ]);
    }

    // Egy termék adatai
    public function product($id) {

        // Termék adatainak lekérdezése
        $product = Product::join('shops','products.shop_id','shops.id')->join('units','products.unit_id','units.id')->join('categories','products.category_id','categories.id')->where('products.id',$id)->get(['products.id','products.name','products.summary','products.body','products.discount','shops.name AS shop_name','shops.id AS shop_id','units.name AS unit','categories.name AS category_name','products.quantity'])->first();

        // Bruttó ár és a leárazás utáni ár meghatározása
        $product->brutto_price = product_prices($product->id)["brutto_ft"];
        $product->discount_price = product_prices($product->id)["discount_ft"];
        
        // Képek lekérdezése
        $images = Image::where('product_id', $id)->orderBy('sequence')->get();
        
        // Képekhez tartozó URL meghatározása
        foreach ($images AS $image) {
            $image->thumb = asset('images/products/'.$id.'/thumb/'.$image->filename);
            $image->url = asset('images/products/'.$id.'/'.$image->filename);
        }

        // Ha be van jelentkezve
        if (Auth::user()) {

            // Megnézni, hogy kedvelte-e a terméket
            $is_fav = Favourite::where('user_id', Auth::id())->where('product_id', $id)->first();
        
        } else {

            // Ha nincs bejelntkezve, akkor nem kedvelte
            $is_fav = null;
        }

        // Felület betöltése
        return view('buyer.product', [
            'product' => $product,
            'images' => $images,
            'is_fav' => $is_fav
        ]);
    }

    // Regisztrációs felület
    public function register() {
        return view('buyer.register');
    }

    // Regisztráció mentése
    public function register_save(UserInsert $userInsert) {

        // E-mail elküldése
        $is_success = Mail::to($userInsert->user->email)->send(new RegisterMail($userInsert->user));

        // Megnézni, hogy az e-mail küldése sikeres volt-e
        if ($is_success) {

            // Ha igen, akkor pozitív visszajelzés
            return redirect()->route('home')->withMessage('Felhasználói fiók sikeresen létrehozva. A regisztráció befejezéséhez szükség e-mail elküldve.');
        } else {

            // Na nem, akkor hiba jelzése
            return redirect()->route('home')->withErrors(['Felhasználói fiók sikeresen létrehozva. Az aktiváló e-mail elküldése viszont meghiúsult. Kérem vegye fel a kapcsolatot a kollégáinkkal.']);
        }
        
    }

    // Regisztráció aktiválása
    public function register_activate($activation_code) {

        // Fiók aktiválása
        $activate = new UserActivate($activation_code);

        // Megnézni, hogy minden rendben volt-e
        if ($activate->ok) {
            
            // Ha igen, akkor pozitív visszajelzés
            return redirect()->route('home')->withMessage('Felhasználói fiók sikeresen aktiválva.');

        } else {

            // Ha nem, akkor hiba jelzése
            return redirect()->route('home')->withErrors(['Hiba történt az aktiválás során.']);

        }
        
    }

    // Üzlet oldala
    public function shop($id) {

        // Bolt adatainak lekérdezése
        $shop = Shop::where("id", $id)->first();

        // Bolt termékeinek lekérdezése
        $products = get_products([$id]);

        // Felület betöltése
        return view('buyer.shop', [
            'shop' => $shop,
            'products' => $products
        ]);
    }

}
