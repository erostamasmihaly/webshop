<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Favourite;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class InteractionSeeder extends Seeder
{

    public function run(): void
    {

        // Vásárló
        $buyer = User::where('name','vasarlo')->first();

        // Termékek
        $product_1 = Product::find(1);
        $product_2 = Product::find(7);

        // Méret
        $size = Category::where('name', 'XL')->first();

        // Vásárló megadja az adatai, hogy tudjon fizetni
        User::where("id", $buyer->id)->update([
            "country" => "Magyarország",
            "state" => "Borsod-Abaúj-Zemplén",
            "zip" => "3530",
            "city" => "Miskolc",
            "address" => "Király utca 12. 2/1."
        ]);

        // Vásárló frissítése
        $buyer->refresh();

        // Vásárló kedvelte az első terméket
        Favourite::insertOrIgnore([
            "id" => 1,
            "user_id" => $buyer->id,
            "product_id" => $product_1->id,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Vásárló berakta a kosárba az első terméket
        Cart::insertOrIgnore([
            "id" => 1,
            "user_id" => $buyer->id,
            "product_id" => $product_1->id,
            "size_id" => $size->id,
            "quantity" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Vásárló berakta a kosárba a második terméket, abból 2 db-ot
        Cart::insertOrIgnore([
            "id" => 2,
            "user_id" => $buyer->id,
            "product_id" => $product_2->id,
            "size_id" => $size->id,
            "quantity" => 2,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Vásárló által megvett termékek adatai
        $items_array = [];
        $cart_1 = Cart::find(1);
        $items_array[0]["ref"] = $cart_1->id;
        $items_array[0]["price"] = product_prices($product_1->id, $size->id)["discount"];
        $items_array[0]["title"] = $product_1->name.": ".$size->name;
        $items_array[0]["amount"] = $cart_1->quantity;
        $cart_2 = Cart::find(2);
        $items_array[1]["ref"] = $cart_2->id;
        $items_array[1]["price"] = product_prices($product_2->id, $size->id)["discount"];
        $items_array[1]["title"] = $product_2->name.": ".$size->name;
        $items_array[1]["amount"] = $cart_2->quantity;
        $items = json_encode($items_array);

        // Összes ár kiszámítása
        $total = ($items_array[0]["price"] * $items_array[0]["amount"]) + ($items_array[1]["price"] * $items_array[1]["amount"]);

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
        Payment::insertOrIgnore([
            "id" => 1,
            "user_id" => $buyer->id,
            "total" => $total,
            "items" => $items,
            "invoice" => $invoice,
            "order_ref" => generate_order_ref(),
            "transaction_id" => "502925405",
            "result" => "SUCCESS",
            "finished" => 1,
            "created_at" => now(),
            "updated_at" => now()   
        ]);

        // Kosarakba is módosult a termék
        Cart::where("id", $cart_1->id)->update([
            "price" => product_prices($cart_1->product_id, $size->id)["discount"],
            "payment_id" => 1
        ]);

        Cart::where("id", $cart_2->id)->update([
            "price" => product_prices($cart_2->product_id, $size->id)["discount"],
            "payment_id" => 1
        ]);

        // Kosarak frissítése
        $cart_1->refresh();
        $cart_2->refresh();

        // Termékek mennyisége is csökken
        ProductPrice::where("id", $cart_1->product_id)->where("size_id", $size->id)->update([
            "quantity" => $product_1->quantity-$cart_1->quantity
        ]);

        ProductPrice::where("id", $cart_2->product_id)->where("size_id", $size->id)->update([
            "quantity" => $product_2->quantity-$cart_2->quantity
        ]);

        // Vásárló véleményt mond az első termékről
        Rating::insertOrIgnore([
            "id" => 1,
            "user_id" => $buyer->id,
            "product_id" => $product_1->id,
            "stars" => 4,
            "title" => "Sajnos egy kicsit szűkös.",
            "created_at" => now(),
            "updated_at" => now()  
        ]);

        // Vélemény lekérdezése
        $rating = Rating::find(1);

        // Alkalmazott elfogadta a véleményt
        Rating::where("id", $rating->id)->update([
            "moderated" => 1,
            "updated_at" => now()
        ]);

        // Vélemény frissítése
        $rating->refresh();

    }
}
