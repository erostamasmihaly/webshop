<?php

namespace App\Http\Services;

use App\Http\Requests\ProductPriceRequest;
use App\Models\ProductPrice;
use Illuminate\Support\Facades\DB;

class ProductPriceUpdate
{
    private $product_id, $size_id, $price, $vat, $discount, $quantity;

    // Adatok lekérdezése
    public function __construct(ProductPriceRequest $productPriceRequest)
    {
        $this->product_id = $productPriceRequest->product_id;
        $this->size_id = $productPriceRequest->size_id;
        $this->price = $productPriceRequest->price;
        $this->vat = $productPriceRequest->vat;
        $this->discount = $productPriceRequest->discount;
        $this->quantity = $productPriceRequest->quantity;
        $this->updateProductPrice();
    }

    // Termék ár frissítése
    private function updateProductPrice()
    {
        DB::transaction(function () {

            // Megnézni, hogy ezen termék ezen mérettel fel van-e már véve
            $product_price = ProductPrice::where('product_id', $this->product_id)->where('size_id', $this->size_id)->first();

            // Létrehozás, ha még nincsen
            if (!$product_price) {
                $product_price = new ProductPrice();
                $product_price->size_id = $this->size_id;
                $product_price->product_id = $this->product_id;
            }

            // Csak akkor legyen mennyiség módosítva, ha nem 0
            if ($this->quantity>0) {
                $product_price->quantity = $this->quantity;
            }

            // Minden más módosítása
            $product_price->price = $this->price;
            $product_price->vat = $this->vat;
            $product_price->discount = $this->discount;
            $product_price->brutto_price = brutto_price($this->price, $this->vat);
            $product_price->discount_price = discount_price($product_price->brutto_price, $this->discount);
            $product_price->save();
            

        });
    }
}