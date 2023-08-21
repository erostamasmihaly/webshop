<?php

namespace App\Http\Services;

use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductUpdate
{
    public $name;
    private $id, $summary, $body, $price, $category_id, $quantity, $active, $vat, $discount, $shop_id, $unit_id;

    // Adatok lekérdezése
    public function __construct(ProductUpdateRequest $productUpdateRequest)
    {
        $this->id = $productUpdateRequest->id;
        $this->name = $productUpdateRequest->name;
        $this->summary = $productUpdateRequest->summary;
        $this->body = $productUpdateRequest->body;
        $this->price = $productUpdateRequest->price;
        $this->category_id = $productUpdateRequest->category_id;
        $this->quantity = $productUpdateRequest->quantity;
        $this->active = $productUpdateRequest->active;
        $this->vat = $productUpdateRequest->vat;
        $this->discount = $productUpdateRequest->discount;
        $this->shop_id = $productUpdateRequest->shop_id;
        $this->unit_id = $productUpdateRequest->unit_id;
        $this->updateProduct();
    }

    // Termék frissítése
    private function updateProduct()
    {
        DB::transaction(function () {

            // Létrehozás vagy megnyitás
            if ($this->id==0) {
                $product = new Product();
            } else {
                $product = Product::find($this->id);
            }

            // További adatok módosítása
            $product->name = $this->name;
            $product->body = $this->body;
            $product->summary = $this->summary;
            $product->price = $this->price;
            $product->category_id = $this->category_id;
            $product->quantity = $this->quantity;
            $product->active = $this->active;
            $product->vat = $this->vat;
            $product->discount = $this->discount;
            $product->shop_id = $this->shop_id;
            $product->unit_id = $this->unit_id;
            
            // Mentés
            $product->save();

        });
    }
}