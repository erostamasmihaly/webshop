<?php

namespace App\Http\Services;

use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Sorrend elmentése
class ImageSequence {

    private $images, $product_id;

    // Adatok lekérdezése
    function __construct(Request $request) {
        $this->images = $request->images;
        $this->product_id = $request->product_id;
        $this->main();
    }

    // Sorrend módosítása
    private function main () {
        DB::transaction(function() {

            // JSON átalakítása tömbbé
            $array = json_decode($this->images, TRUE);

            // Végigmenni minden egyes képen
            for ($i=0; $i<count($array); $i++) {
                
                // Felvinni a képet az új sorrenddel
                Image::where('id', $array[$i])->update(['sequence' => $i]);
            }

            // Felhasználó lekérdezése
            $user = User::find(Auth::id());

            // Ingatlan lekérdezése
            $product = Product::find($this->product_id);

            // Naplózás
            if ($product!=null) {
                activity()->causedBy($user)->performedOn($product)->withProperties(['attributes' => $array])->event('image_sequence')->log('image_sequence');
            }

        });
    }

}