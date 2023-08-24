<?php

namespace App\Http\Services;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Vezérkép elmentése
class ImageMain {

    private $image_id, $product_id;

    // Adatok lekérdezése
    function __construct(Request $request) {
        $this->image_id = $request->image_id;
        $this->product_id = $request->product_id;
        $this->main();
    }

    // Vezérkép jelölés módosítása
    private function main () {
        DB::transaction(function() {

            // Aktuális verzérkép esetén ezen jelölés törlése
            Image::where('product_id',$this->product_id)->where('is_main', 1)->update(['is_main' => 0]);

            // Bejelölni az új vezérképet
            Image::where('product_id',$this->product_id)->where('id', $this->image_id)->update(['is_main' => 1]);

            // Kép megadása
            $image = Image::where('id',$this->image_id)->first()->filename;

            // Létrehozni a kisebb méretet a vezérképből
            create_main_image($this->product_id, $image);

        });
    }

}