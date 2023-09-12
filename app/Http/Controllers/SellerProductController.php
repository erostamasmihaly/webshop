<?php

namespace App\Http\Controllers;

use App\Http\Services\ImageDelete;
use App\Http\Services\ImageMain;
use App\Http\Services\ImageSequence;
use App\Http\Services\ImageUpload;
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

        // Oldal meghívása
        return view('seller.product',[
            'products' => get_products($shops)
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

        } else {
        
            // Termék adatainak lekérdezése
            $product = Product::find($id);
        }

        // Termék kategóriák lekérdezése
        $categories = Category::where('category_group_id',1)->orderBy('sequence')->get();

        // Mértékegységek lekérdezése
        $units = Category::where('category_group_id',2)->orderBy('sequence')->get();

        // Üzletek lekérdezése
        $shops = Shop::get();

        // Értékelések lekérdezése
        $ratings = get_ratings($id, false)["ratings"];

        // Oldal meghívása
        return view('seller.product_edit',[
            'product' => $product,
            'categories' => $categories,
            'units' => $units,
            'shops' => $shops,
            'ratings' => $ratings
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
}
