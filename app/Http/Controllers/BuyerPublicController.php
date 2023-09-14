<?php

namespace App\Http\Controllers;

use App\Http\Services\UserActivate;
use App\Http\Services\UserInsert;
use App\Mail\RegisterMail;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Favourite;
use App\Models\Image;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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
        return view('buyer.index');
    }

    // Fő oldal - termékek lekérdezése
    public function products(Request $request) {

        // Kategória lekérdezése
        $category_id = ($request->category_id=="null") ? null : $request->category_id;

        // Azon kategóriák lekérdezése, amelyek ehhez vannak hozzárendelve
        $array["categories"] = Category::where('category_id', $category_id)->where('category_group_id', 1)->orderBy('sequence')->get(['id','name']);

        // Vissza érték lekérdezése
        if ($category_id!=null) {
            $parent_id = Category::find($category_id)->category_id;
        } else {
            $parent_id = null;
        }
        $array["back_id"] = $parent_id;

        // Azon termékek lekérdezése, amelyek ehhez vannak hozzárendelve
        $array["products"] = get_products([$category_id]);

        // JSON válasz küldése ebből a tömbből
        $array["OK"] = 1;
        return Response::json($array);
        
    }

    // Egy termék adatai
    public function product($id) {

        // Termék adatainak lekérdezése
        $product = Product::join('shops','products.shop_id','shops.id')->join('categories AS units','products.unit_id','units.id')->join('categories','products.category_id','categories.id')->where('products.id',$id)->get(['products.id','products.name','products.summary','products.body','products.discount','shops.name AS shop_name','shops.id AS shop_id','units.name AS unit','categories.name AS category_name','products.quantity'])->first();

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

            // Megnézni, hogy megvette-e a terméket
            $is_buyed = Cart::where('user_id', Auth::id())->where('product_id', $id)->whereNotNull('payment_id')->first();
        
        } else {

            // Ha nincs bejelntkezve, akkor nem kedvelte és nem vásárolta meg
            $is_fav = null;
            $is_buyed = null;
        }

        // Értékelések neveinek lekérdezése
        $rating_names = Category::where('category_group_id',3)->orderBy('sequence','desc')->get();

        // Kedvelések száma
        $fav_total = Favourite::where('product_id', $id)->count();

        // Felület betöltése
        return view('buyer.product', [
            'product' => $product,
            'images' => $images,
            'is_fav' => $is_fav,
            'is_buyed' => $is_buyed,
            'rating_names' => $rating_names,
            'fav_total' => $fav_total
        ]);
    }

    // Termék értékeléseinek lekérdezése
    public function product_rating(Request $request) {

        // Értékeléssel kapcsolatos tömb lekérdezése
        $ratings_array = get_ratings($request->product_id);

        // Adatok lekérdezése és behelyezése egy tömbbe
        $array["data"] = $ratings_array["ratings"];
        $array["recordsTotal"] = $ratings_array["total"][0]["total"];
        $array["draw"] = 1;
        $array["recordsFiltered"] = $array["recordsTotal"];
        $array["others"] = $ratings_array["total"][0];

        // Visszatérés ezen tömbbel
        return Response::json($array);
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
