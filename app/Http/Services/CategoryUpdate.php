<?php

namespace App\Http\Services;

use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryUpdate
{
    public $name;
    private $id;

    // Adatok lekérdezése
    public function __construct(CategoryUpdateRequest $categoryUpdateRequest)
    {
        $this->id = $categoryUpdateRequest->id;
        $this->name = $categoryUpdateRequest->name;
        $this->updateCategory();
    }

    // Kategória frissítése
    private function updateCategory()
    {
        DB::transaction(function () {

            // Létrehozás vagy megnyitás
            if ($this->id==0) {
                $category = new Category();
            } else {
                $category = Category::find($this->id);
            }

            // Lekérdezni, hogy van-e szülőtlen kategória és ha igen, akkor melyik az utolsó
            $has_last_sequence = Category::whereNull('category_id')->orderBy('sequence','desc')->first();
            if ($has_last_sequence) {

                // Ha van, akkor a következő az 1-el nagyobb sorszámot fogja kapni
                $sequence = $has_last_sequence->sequence + 1;
            } else {

                // Ha nincs, akkor 0 lesz a sorszám
                $sequence = 1;
            }

            // További adatok módosítása
            $category->name = $this->name;
            $category->sequence = $sequence;
            
            // Mentés
            $category->save();

        });
    }
}