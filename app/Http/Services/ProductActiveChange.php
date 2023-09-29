<?php

namespace App\Http\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductActiveChange
{
    private $id;
    public $active, $error;

    // Adatok lekérdezése
    public function __construct($id) {
        $this->id = $id;
        $this->error = false;
        $this->change();
    }

    // Állapot módosítása
    private function change() {

        DB::transaction(function () {

            // Termék lekérdezése
            $product = Product::find($this->id);

            // Termékhez tartozó ár-méretek számának lekérdezése
            $count = count($product->sizes_array());

            if ($count>0) {
                
                //// Ha minimum egy ilyen meg van adva
                // Termék új aktív állapot a mostani ellentéte legyen
                if ($product->active==1) {
                    $product->active = 0; 
                } else {
                    $product->active = 1;
                }

                // Termék mentése
                $product->save();

                // Visszatérés az új értékkel
                $this->active = $product->active;

            } else {

                // Jelezni, hogy hiba van
                $this->error = true;
            }


        });
    }
}