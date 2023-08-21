<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductUpdate;
use App\Models\Product;
use Illuminate\Http\Request;

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

        } else {
        
            // Termék adatainak lekérdezése
            $product = Product::find($id);
        }

        // Oldal meghívása
        return view('seller.product_edit',[
            'product' => $product
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
}
