<?php

namespace App\Http\Controllers;

use App\Http\Services\ShopUpdate;
use App\Models\Shop;
use Illuminate\Http\Request;

class AdminShopController extends Controller
{
    // Csak az adminok léphetnek be
    public function __construct()
    {
        $this->middleware('admin');
    }

    // Üzletek listája
    public function index() {

        // Üzletek lekérdezése
        $shops = Shop::get();

        // Oldal meghívása
        return view('admin.shop',[
            'shops' => $shops
        ]);
    }    

    // Üzlet szerkesztése
    public function edit($id) {

        if ($id==0) {
            
            // Új üzlet
            $shop = new Shop();
            $shop->id = 0;
            $shop->latitude = 48.1037;
            $shop->longitude = 20.7781;

        } else {
        
            // Üzlet adatainak lekérdezése
            $shop = Shop::find($id);
        }

        // Oldal meghívása
        return view('admin.shop_edit',[
            'shop' => $shop
        ]);
    }

    // Üzlet módosítása
    public function update(ShopUpdate $shopUpdate) {
        return redirect()->route('admin_shop')->withMessage($shopUpdate->name.' sikeresen módosítva lett.');
    }

    // Új üzlet létrehozása
    public function create() {

        // Ugrás a Szerkesztő oldalra
        return redirect()->route('admin_shop_edit', 0);

    }
}
