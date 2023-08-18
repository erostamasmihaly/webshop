<?php

namespace App\Http\Controllers;

use App\Http\Services\ShopUpdate;
use App\Http\Services\UserShopUpdate;
use App\Models\Position;
use App\Models\Shop;
use App\Models\User;
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

        // Üzlet alkalmazottjainak lekérdezése
        $users = User::join('user_shops','user_shops.user_id','users.id')->join('positions','user_shops.position_id','positions.id')->where('positions.shop_id',$id)->get(['users.surname','users.forename','positions.name AS position']);

        // Oldal meghívása
        return view('admin.shop_edit',[
            'shop' => $shop,
            'users' => $users
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

    // Alkalmazott szerkesztése
    public function user_edit($shop_id, $user_id) {

        // Seller joggal rendelkező felhasználók lekérdezése
        $sellers = User::join('user_roles','user_roles.user_id','users.id')->join('roles','user_roles.role_id','roles.id')->where('roles.name','seller')->get(['users.id','users.surname','users.forename']);

        // Bolthoz tartozó munkakörök lekérdezése
        $positions = Position::where('shop_id', $shop_id)->get();
        
        // Oldal meghívása
        return view('admin.shop_edit_user',[
            'sellers' => $sellers,
            'positions' => $positions
        ]);
    }

    // Alkalmazott módosítása
    public function user_update(UserShopUpdate $userShopUpdate) {

        return redirect()->route('admin_shop_edit', $userShopUpdate->shop_id)->withMessage('Alkalmazott sikeresen módosítva lett.');
    }
}
