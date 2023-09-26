<?php

namespace App\Http\Services;

use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class ProductUpdate
{
    public $name;
    private $id, $summary, $body, $group_id, $age_id, $gender_id, $shop_id, $unit_id;

    // Adatok lekérdezése
    public function __construct(ProductUpdateRequest $productUpdateRequest)
    {
        $this->id = $productUpdateRequest->id;
        $this->name = $productUpdateRequest->name;
        $this->summary = $productUpdateRequest->summary;
        $this->body = $productUpdateRequest->body;
        $this->group_id = $productUpdateRequest->group_id;
        $this->age_id = $productUpdateRequest->age_id;
        $this->gender_id = $productUpdateRequest->gender_id;
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
                $new = true;
            } else {
                $product = Product::find($this->id);
                $new = false;
            }

            // További adatok módosítása
            $product->name = $this->name;
            $product->body = $this->body;
            $product->summary = $this->summary;
            $product->shop_id = $this->shop_id;

            // Termék mentése
            $product->save();

            if ($new) {

                // Termékcsoport
                $product_group = new ProductCategory();
                $product_group->category_group_id = get_category_group_id('Termékcsoportok');
                $product_group->category_id = $this->group_id;
                $product_group->product_id = $product->id;
                $product_group->save();

                // Nem
                $product_group = new ProductCategory();
                $product_group->category_group_id = get_category_group_id('Nemek');
                $product_group->category_id = $this->gender_id;
                $product_group->product_id = $product->id;
                $product_group->save();
                
                // Korosztály
                $product_group = new ProductCategory();
                $product_group->category_group_id = get_category_group_id('Korosztályok');
                $product_group->category_id = $this->age_id;
                $product_group->product_id = $product->id;
                $product_group->save();

                // Mértékegység
                $product_group = new ProductCategory();
                $product_group->category_group_id = get_category_group_id('Mértékegységek');
                $product_group->category_id = $this->unit_id;
                $product_group->product_id = $product->id;
                $product_group->save();

            } else {

                // Termékcsoport
                $product->group->category_id = $this->group_id;

                // Nem
                $product->gender->category_id = $this->gender_id;

                // Korosztály
                $product->age->category_id = $this->age_id;

                // Mértékegység
                $product->unit->category_id = $this->unit_id;

            }
            
            // Termék mentése
            $product->push();

        });
    }
}