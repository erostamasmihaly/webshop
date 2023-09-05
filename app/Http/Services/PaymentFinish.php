<?php

namespace App\Http\Services;

use App\Models\Cart;
use App\Models\Product;
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

            for ($i=0; $i<count($this->items); $i++) {
                $item = $this->items[$i];
                $cart = Cart::find($item->ref);
                $cart->payment_id = $this->payment_id;
                $cart->price = $item->price;
                $cart->save();

                $product = Product::find($cart->product_id);
                $product->quantity -= $cart->quantity;
                $product->save(); 
            }
        });
    }
}
    