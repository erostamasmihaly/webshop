<?php

namespace App\Http\Services;

use App\Http\Requests\ProductPriceRequest;
use App\Models\ProductPrice;
use Illuminate\Support\Facades\DB;

class ProductPriceUpdate
{
    private $product_id, $size_id, $price, $vat, $discount, $quantity, $price_check, $vat_check, $discount_check, $quantity_check;

    // Adatok lekérdezése
    public function __construct(ProductPriceRequest $productPriceRequest)
    {
        $this->product_id = $productPriceRequest->product_id;
        $this->size_id = $productPriceRequest->size_id;
        $this->price = $productPriceRequest->price;
        $this->vat = $productPriceRequest->vat;
        $this->discount = $productPriceRequest->discount;
        $this->quantity = $productPriceRequest->quantity;
        $this->price_check = $productPriceRequest->price_check;
        $this->vat_check = $productPriceRequest->vat_check;
        $this->discount_check = $productPriceRequest->discount_check;
        $this->quantity_check = $productPriceRequest->quantity_check;
        $this->updateProductPrice();
    }

    // Termék ár frissítése
    private function updateProductPrice()
    {
        DB::transaction(function () {

            // Megnézni, hogy ezen termék ezen mérettel fel van-e már véve
            $product_price = ProductPrice::where('product_id', $this->product_id)->where('size_id', $this->size_id)->first();

            
            if (!$product_price) {

                // Létrehozás, ha még nincsen
                $product_price = new ProductPrice();
                $product_price->size_id = $this->size_id;
                $product_price->product_id = $this->product_id;
                $product_price->quantity = $this->quantity;
                $product_price->price = $this->price;
                $product_price->vat = $this->vat;
                $product_price->discount = $this->discount;
                
            } else {

                // Módosítás, de csak akkor, amikor kell
                if ($this->quantity_check == 1) {
                    $product_price->quantity = $this->quantity;
                }
                if ($this->price_check == 1) {
                    $product_price->price = $this->price;
                }
                if ($this->vat_check == 1) {
                    $product_price->vat = $this->vat;
                }
                if ($this->discount_check == 1) {
                    $product_price->discount = $this->discount;
                }
            }

            // Árazás mentése
            $product_price->save();

            // Árak meghatározása és elmentése
            $product_price->brutto_price = brutto_price($product_price->price, $product_price->vat);
            $product_price->discount_price = discount_price($product_price->brutto_price, $product_price->discount);

            // Árazás mentése
            $product_price->save();
            

        });
    }
}