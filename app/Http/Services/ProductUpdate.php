<?php

namespace App\Http\Services;

use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class ProductUpdate
{
    public $name;
    private $id, $temporary_id, $summary, $body, $price, $group_id, $age_id, $gender_id, $size_id, $quantity, $active, $vat, $discount, $shop_id, $unit_id;

    // Adatok lekérdezése
    public function __construct(ProductUpdateRequest $productUpdateRequest)
    {
        $this->id = $productUpdateRequest->id;
        $this->temporary_id = $productUpdateRequest->temporary_id;
        $this->name = $productUpdateRequest->name;
        $this->summary = $productUpdateRequest->summary;
        $this->body = $productUpdateRequest->body;
        $this->price = $productUpdateRequest->price;
        $this->group_id = $productUpdateRequest->group_id;
        $this->size_id = $productUpdateRequest->size_id;
        $this->age_id = $productUpdateRequest->age_id;
        $this->gender_id = $productUpdateRequest->gender_id;
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
                $new = true;
            } else {
                $product = Product::find($this->id);
                $new = false;
            }

            // További adatok módosítása
            $product->name = $this->name;
            $product->body = $this->body;
            $product->summary = $this->summary;
            $product->price = $this->price;
            $product->quantity = $this->quantity;
            $product->active = $this->active;
            $product->vat = $this->vat;
            $product->discount = $this->discount;
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
                
                // Méret
                $product_group = new ProductCategory();
                $product_group->category_group_id = get_category_group_id('Méretek');
                $product_group->category_id = $this->size_id;
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

                // Méret
                $product->size->category_id = $this->size_id;

                // Nem
                $product->gender->category_id = $this->gender_id;

                // Korosztály
                $product->age->category_id = $this->age_id;

                // Mértékegység
                $product->unit->category_id = $this->unit_id;

            }
            
            // Termék mentése
            $product->push();

            // Ha új termék lett létrehozva
            if ($new) {

                // Lekérdezni a képeket az ideiglenes azonosítóval
                $image = Image::where('product_id', $this->temporary_id);

                // Ha vannak ilyen képek
                if ($image->first()) {

                    // Módosítani a hozzárendelt képek termék azonosítóját: ideiglenes > állandó
                    $image->update(['product_id' => $product->id]);

                    // Régi könyvtár
                    $old_dir = public_path('images/products/'.$this->temporary_id);

                    // Új könyvtár
                    $new_dir = public_path('images/products/'.$product->id);

                    // Átnevezni a fájlokat tartalmazó könyvtárat
                    rename($old_dir, $new_dir);
                }
                
            }

        });
    }
}