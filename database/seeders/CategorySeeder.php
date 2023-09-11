<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        // Ha még nincsen kategória létrehozva
        if (Category::count()==0) {

            // Darab
            $category = new Category();
            $category->name = "darab";
            $category->category_group_id = 2;
            $category->sequence = 1;
            $category->save();

            // Liter
            $category = new Category();
            $category->name = "liter";
            $category->category_group_id = 2;
            $category->sequence = 2;
            $category->save();

            // Kilogramm
            $category = new Category();
            $category->name = "kg";
            $category->category_group_id = 2;
            $category->sequence = 3;
            $category->save();

            // Méter
            $category = new Category();
            $category->name = "m";
            $category->category_group_id = 2;
            $category->sequence = 4;
            $category->save();

        }
    }
}
