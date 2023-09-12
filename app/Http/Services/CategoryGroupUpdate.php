<?php

namespace App\Http\Services;

use App\Http\Requests\CategoryGroupUpdateRequest;
use App\Models\CategoryGroup;
use Illuminate\Support\Facades\DB;

class CategoryGroupUpdate
{
    public $name;
    private $id;

    // Adatok lekérdezése
    public function __construct(CategoryGroupUpdateRequest $categoryGroupUpdateRequest)
    {
        $this->id = $categoryGroupUpdateRequest->id;
        $this->name = $categoryGroupUpdateRequest->name;
        $this->updateCategoryGroup();
    }

    // Kategória frissítése
    private function updateCategoryGroup()
    {
        DB::transaction(function () {

            // Létrehozás vagy megnyitás
            if ($this->id==0) {
                $category_group = new CategoryGroup();
            } else {
                $category_group = CategoryGroup::find($this->id);
            }

            // További adatok módosítása
            $category_group->name = $this->name;
            
            // Mentés
            $category_group->save();

        });
    }
}