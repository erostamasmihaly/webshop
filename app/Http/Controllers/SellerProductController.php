<?php

namespace App\Http\Controllers;

use App\Http\Services\ImageDelete;
use App\Http\Services\ImageMain;
use App\Http\Services\ImageSequence;
use App\Http\Services\ImageUpload;
use App\Http\Services\ProductActiveChange;
use App\Http\Services\ProductPriceUpdate;
use App\Http\Services\ProductUpdate;
use App\Http\Services\RatingModeration;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class SellerProductController extends Controller
{
    // Csak az alkalmazottak léphetnek be
    public function __construct()
    {
        $this->middleware('seller');
    }

    // Termékek listája
    public function index() {

        // Minden olyan bolt lekérdezése, ami a felhasználóhoz hozzá van rendelve
        $shops = Shop::join('positions','positions.shop_id','shops.id')->join('user_positions','user_positions.position_id','positions.id')->where('user_positions.user_id', Auth::id())->pluck('shops.id')->toArray();

        // Szűrés miatt ebből egy tömb létrehozása
        $array["shops"] = $shops;

        // Termékek lekérdezése
        $products = get_products(null, true, $array, null, null, false);

        // Oldal meghívása
        return view('seller.product',[
            'products' => $products
        ]);
    }    

    // Termék szerkesztése
    public function edit($id) {

        if ($id==0) {
            
            // Új termék
            $product = new Product();
            $product->id = 0;
            $product->vat = 27;
            $product->quantity = 1;
            $product->discount = 0;

            // Nincs értékelés
            $ratings = null;

            // Új
            $new = TRUE;

        } else {
        
            // Termék adatainak lekérdezése
            $product = Product::find($id);

            // Értékelések lekérdezése
            $ratings = get_ratings($id, false)["ratings"];

            // Nem új
            $new = FALSE;
            
        }

        // Termékcsoport lekérdezése
        $groups = Category::where('category_group_id', get_category_group_id('Termékcsoportok'))->orderBy('sequence')->get();

        // Mértékegységek lekérdezése
        $units = Category::where('category_group_id', get_category_group_id('Mértékegységek'))->orderBy('sequence')->get();

        // Nemek lekérdezése
        $genders = Category::where('category_group_id', get_category_group_id('Nemek'))->orderBy('sequence')->get();

        // Méretek lekérdezése
        $sizes = Category::where('category_group_id', get_category_group_id('Méretek'))->orderBy('sequence')->get();

        // Korosztályok lekérdezése
        $ages = Category::where('category_group_id', get_category_group_id('Korosztályok'))->orderBy('sequence')->get();

        // Üzletek lekérdezése
        $shops = Shop::get();

        // Oldal meghívása
        return view('seller.product_edit',[
            'product' => $product,
            'groups' => $groups,
            'units' => $units,
            'sizes' => $sizes,
            'genders' => $genders,
            'ages' => $ages,
            'shops' => $shops,
            'ratings' => $ratings,
            'new' => $new
        ]);
    }

    // Termék módosítása
    public function update(ProductUpdate $productUpdate) {
        return redirect()->route('seller_product')->withMessage($productUpdate->name.' sikeresen módosítva lett.');
    }

    // Új termék létrehozása
    public function create() {

        // Ugrás a Szerkesztő oldalra
        return redirect()->route('seller_product_edit', 0);

    }

    // Kép feltöltése
    public function image_upload(ImageUpload $imageUpload) {

        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Képek lekérdezése
    public function image_list(Request $request)
    {

        // Azonosító lekérdezése
        $product_id = $request->product_id;

        // Lekérdezni, a hozzárendelt képeket
        $array['images'] = Image::where('product_id',$product_id)->orderBy('sequence','asc')->get(['id','filename','is_main'])->toArray();

        // Lekérdezni a könyvtár elérését
        $array['dir'] = asset('images/products/'.$product_id);
        
        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    } 

    // Kép vezérképpé tétele
    public function image_main(ImageMain $imageMain) {
        
        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Kép törlése
    public function image_delete(ImageDelete $imageDelete) {
        
        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Kép sorrend elmentése
    public function image_sequence(ImageSequence $imageSequence) {
        
        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Termék értékeléseinek lekérdezése
    public function product_rating(Request $request) {

        // Értékeléssel kapcsolatos tömb lekérdezése
        $ratings_array = get_ratings($request->product_id, false);

        // Adatok lekérdezése és behelyezése egy tömbbe
        $array["data"] = $ratings_array["ratings"];
        $array["recordsTotal"] = $ratings_array["total"][0]["total"];
        $array["draw"] = 1;
        $array["recordsFiltered"] = $array["recordsTotal"];

        // Visszatérés ezen tömbbel
        return Response::json($array);
    } 

    // Értékelés moderálásának módosítása
    public function product_rating_moderation(RatingModeration $ratingModeration) {
        
        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Termék árainak lekérdezése
    public function product_price(Request $request) {

        // Termék árainak lekérdezése
        $prices = Product::find($request->id)->prices;

        foreach($prices AS $price) {
            $price->vat = numformat_with_unit($price->vat,"%");
            $price->discount = numformat_with_unit($price->discount,"%");
            $price->netto_price = product_prices($request->id, $price->size_id)["netto_ft"]; 
            $price->brutto_price = product_prices($request->id, $price->size_id)["brutto_ft"];
            $price->discount_price = product_prices($request->id, $price->size_id)["discount_ft"];
            $price->size_name = Category::find($price->size_id)->name;
        }

        // Adatok lekérdezése és behelyezése egy tömbbe
        $array["data"] = $prices;
        $array["recordsTotal"] = $prices->count();
        $array["draw"] = 1;
        $array["recordsFiltered"] = $prices->count();

        // Válasz küldése
        return Response::json($array);

    }

    // Termék árának módosítása
    public function product_price_update(ProductPriceUpdate $productPriceUpdate) {
            
        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Termék aktív állapotának módosítása
    public function active($product_id) {

        // Termék állapotának módosítása
        $productActivePrice = new ProductActiveChange($product_id);

        if ($productActivePrice->error) {

            //// Ha volt hiba
            // Visszatérés a hibával
            return redirect()->back()->withErrors([
                "prices" => "Még nincs beárazva a termék, így nem lehet publikálni!"
            ]);
        } else {

            //// Ha minden rendben volt
            // Állapotfüggő üzenet
            if ($productActivePrice->active == 1) {
                $message = "Termék sikeresen publikálva lett!";
            } else {
                $message = "Termék sikeresen el lett rejtve!";
            }

            // Visszatérés az üzenettel
            return redirect()->back()->withMessage($message);
        }

    }
}
