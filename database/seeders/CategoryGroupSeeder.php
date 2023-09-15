<?php

namespace Database\Seeders;

use App\Models\CategoryGroup;
use Illuminate\Database\Seeder;

class CategoryGroupSeeder extends Seeder
{

    public function run(): void
    {

        // Kategória csoportok felvitele
        $array = ["Termékcsoportok","Mértékegységek","Értékelések","Méretek","Nemek","Korosztályok"];
        for ($i = 0; $i < count($array); $i++) {
            CategoryGroup::insertOrIgnore([
                "id" => $i+1,
                "name" => $array[$i],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }
    }
}
