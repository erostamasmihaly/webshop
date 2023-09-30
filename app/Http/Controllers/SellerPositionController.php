<?php

namespace App\Http\Controllers;

use App\Http\Services\PositionUpdate;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SellerPositionController extends Controller
{
    // Csak az alkalmazottak léphetnek be
    public function __construct()
    {
        $this->middleware('seller');
    }

    // Munkakörök listája
    public function index() {

        // Minden olyan munkakör lekérdezése, amit a boltoshoz is hozzá lehet rendelni
        $positions = User::find(Auth::id())->possible_positions();

        // Oldal meghívása
        return view('seller.position',[
            'positions' => $positions
        ]);
    }    

    // Munkakör szerkesztése
    public function edit($id) {

        if ($id==0) {
            
            // Új termék
            $position = new Position();
            $position->id = 0;

        } else {
        
            // Munkakör adatainak lekérdezése
            $position = Position::find($id);
            
        }
        
        // Boltoshoz tartozó üzletek lekérdezése
        $shops = User::find(Auth::id())->shops();

        // Oldal meghívása
        return view('seller.position_edit',[
            'position' => $position,
            'shops' => $shops
        ]);

    }

    // Munkakör módosítása
    public function update(PositionUpdate $positionUpdate) {
        return redirect()->route('seller_position')->withMessage($positionUpdate->name.' sikeresen módosítva lett.');
    }

    // Új termék létrehozása
    public function create() {

        // Ugrás a Szerkesztő oldalra
        return redirect()->route('seller_position_edit', 0);

    }
}
