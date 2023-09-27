<?php

namespace App\Http\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentFinish
{
    private $items, $payment_id;

    // Adatok lekérdezése
    public function __construct(Request $request)
    {
        $this->items = $request->items;
        $this->payment_id = $request->payment_id;
        $this->finish();
    }

    // Vásárlás befejezése
    private function finish()
    {
        DB::transaction(function () {

            // Végigmenni minden egyes elemen
            for ($i=0; $i<count($this->items); $i++) {

                // Elem lekérdezése
                $item = $this->items[$i];

                // Elemhez tartozó kosár bejegyzés frissítése 
                $cart = Cart::find($item->ref);
                $cart->payment_id = $this->payment_id;
                $cart->price = $item->price;
                $cart->save();

                // Termék és mérethez tartozó mennyiség csökkentése
                $productPrice = ProductPrice::where("product_id",$cart->product_id)->where("size_id",$cart->size_id)->first();
                $productPrice->quantity -= $cart->quantity;
                $productPrice->save(); 
            }
        });
    }
}
    