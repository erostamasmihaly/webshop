<?php

namespace App\Http\Services;

use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class UserUpdate
{
    public $name;
    private $id, $category_id, $sequence;

    // Adatok lekérdezése
    public function __construct(CategoryUpdateRequest $categoryUpdateRequest)
    {
        $this->id = $categoryUpdateRequest->id;
        $this->name = $categoryUpdateRequest->name;
        $this->category_id = $categoryUpdateRequest->category_id;
        $this->sequence = $categoryUpdateRequest->sequence;
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

            // További adatok módosítása
            $category->name = $this->name;
            $category->category_id = $this->category_id;
            $category->sequence = $this->sequence;
            
            // Mentés
            $category->save();

        });
    }
}