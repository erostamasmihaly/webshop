<?php

namespace App\Http\Services;

use App\Http\Controllers\AdminImageController;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Alapértelmezett vezérkép beállítása
class ImageMainDefault {

    private $product_id;

    // Adatok lekérdezése
    function __construct(Request $request) {
        $this->product_id = $request->product_id;
        $this->first_as_main();
    }

    // Alapértelmezett vezérkép beállítása
    private function first_as_main() {
        DB::transaction(function() {
            
            // Megnézni, hogy van-e beállítva vezérkép az adott ingatlan esetén
            $has_main_image = Image::where('product_id',$this->product_id)->where('is_main',1)->count();

            // Ha nincs, akkor az elsőt beállítani, mint vezérkép
            if ($has_main_image==0) {
                
                // Sorban a legelső kép lekérdezése
                $first = Image::where('product_id',$this->product_id)->where('sequence',1)->first();

                // Ha van ilyen kép
                if ($first!=null) {

                    // Bejelölni az új vezérképet
                    $first->is_main = 1;
                    $first->save();

                    // Létrehozni az ImageMain-ben megírt függvény által a vezérképet
                    create_main_image($this->product_id, $first->filename);

                }
            }
        });
    }

}