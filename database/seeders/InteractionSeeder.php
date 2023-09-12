<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Rating;
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

        // Vásárló megadja az adatai, hogy tudjon fizetni
        DB::table("users")->where("id", $buyer->id)->update([
            "country" => "Magyarország",
            "state" => "Borsod-Abaúj-Zemplén",
            "zip" => "3530",
            "city" => "Miskolc",
            "address" => "Király utca 12. 2/1."
        ]);

        // Vásárló frissítése
        $buyer->refresh();

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
        $cart = Cart::find(1);
        $items_array[0]["ref"] = $cart->id;
        $items_array[0]["price"] = product_prices($product->id)["discount"];
        $items_array[0]["title"] = $product->name;
        $items_array[0]["amount"] = $product->quantity;
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
            "total" => product_prices($cart->product_id)["discount"],
            "items" => $items,
            "invoice" => $invoice,
            "order_ref" => generate_order_ref(),
            "transaction_id" => "502925405",
            "result" => "SUCCESS",
            "finished" => 1,
            "created_at" => get_now(),
            "updated_at" => get_now()   
        ]);

        // Kosárba is módosult a termék
        DB::table("carts")->where("id", 1)->update([
            "price" => product_prices($cart->product_id)["discount"],
            "payment_id" => 1
        ]);

        // Kosár frissítése
        $cart->refresh();

        // Termék mennyisége is csökken eggyel
        DB::table("products")->where("id", $cart->product_id)->update([
            "quantity" => $product->quantity-1
        ]);

        // Termék frissítése
        $product->refresh();

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

        // Vélemény lekérdezése
        $rating = Rating::find(1);

        // Boltos elfogadta a véleményt
        DB::table("ratings")->where("id", $rating->id)->update([
            "moderated" => 1,
            "updated_at" => get_now()
        ]);

        // Vélemény frissítése
        $rating->refresh();

    }
}
