<?php

namespace App\Http\Services;

use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductUpdate
{
    public $name;
    private $id, $summary, $body, $price, $category_id, $quantity;

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

            
            // Mentés
            $product->save();

        });
    }
}