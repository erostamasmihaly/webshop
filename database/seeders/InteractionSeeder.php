<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InteractionSeeder extends Seeder
{

    public function run(): void
    {

        // Vásárló
        $buyer = User::find(2);

        // Boltos
        $seller = User::find(3);

        // Termék
        $product = Product::find(1);

        // Vásárló kedvelte a terméket
        DB::table("favourites")->insertOrIgnore([
            "id" => 1,
            "user_id" => $buyer->id,
            "product_id" => $product->id,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Vásárló berakta a kosárba a terméket
        DB::table("carts")->insertOrIgnore([
            "id" => 1,
            "user_id" => $buyer->id,
            "product_id" => $product->id,
            "quantity" => 1,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Vásárló által megvett termék adatai
        $items_array = [];
        $cart = Cart::join('products','carts.product_id','products.id')->where('carts.id',1)->get(['products.id AS ref','products.name AS title','carts.quantity AS amount'])->first();
        $items_array[0]["ref"] = $cart->ref;
        $items_array[0]["price"] = product_prices($cart->ref)["discount"];
        $items_array[0]["title"] = $cart->title;
        $items_array[0]["amount"] = $cart->amount;
        $items = json_encode($items_array);

        // Vásárló elérhetősége
        $invoice_array = [];
        $invoice_array[0]["name"] = $buyer->surname." ".$buyer->forename;
        $invoice_array[0]["country"] = $buyer->country; 
        $invoice_array[0]["state"] = $buyer->state; 
        $invoice_array[0]["zip"] = $buyer->zip;
        $invoice_array[0]["city"] = $buyer->city; 
        $invoice_array[0]["address"] = $buyer->address;
        $invoice = json_encode($invoice_array);

        // Vásárló kifizette a terméket
        DB::table("payments")->insertOrIgnore([
            "id" => 1,
            "user_id" => $buyer->id,
            "total" => product_prices($cart->ref)["discount"],
            "items" => $items,
            "invoice" => $invoice,
            "order_ref" => "12700116945005728897",
            "transaction_id" => "502925405",
            "result" => "SUCCESS",
            "finished" => 1,
            "created_at" => get_now(),
            "updated_at" => get_now()   
        ]);

        // Kosárba is módosult a termék
        DB::table("carts")->where("id", 1)->update([
            "price" => product_prices($cart->ref)["discount"],
            "payment_id" => 1
        ]);

        // Vásárló véleményt mond a termékről
        DB::table("ratings")->insertOrIgnore([
            "id" => 1,
            "user_id" => $buyer->id,
            "product_id" => $product->id,
            "stars" => 4,
            "title" => "Sajnos egy kicsit szűkös.",
            "created_at" => get_now(),
            "updated_at" => get_now()  
        ]);

        // Boltos elfogadta a véleményt
        DB::table("ratings")->where("id", 1)->update([
            "moderated" => 1,
            "updated_at" => get_now()
        ]);

    }
}
