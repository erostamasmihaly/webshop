<?php

namespace App\Http\Controllers;

use App\Http\Services\ImageDelete;
use App\Http\Services\ImageMain;
use App\Http\Services\ImageUpload;
use App\Http\Services\ProductUpdate;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Unit;
use Illuminate\Http\Request;
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

        // Termékek lekérdezése
        $products = Product::get();

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

        } else {
        
            // Termék adatainak lekérdezése
            $product = Product::find($id);
        }

        // Kategóriák lekérdezése
        $categories = Category::where('is_leaf',1)->get();

        // Mértékegységek lekérdezése
        $units = Unit::get();

        // Üzletek lekérdezése
        $shops = Shop::get();

        // Oldal meghívása
        return view('seller.product_edit',[
            'product' => $product,
            'categories' => $categories,
            'units' => $units,
            'shops' => $shops
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
}
