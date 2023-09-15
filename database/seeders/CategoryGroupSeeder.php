<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryGroupSeeder extends Seeder
{

    public function run(): void
    {

        // Elemek neveinek megadása egy tömbbe
        $array = ["Termék csoportok","Mértékegységek","Értékelések","Méretek"];

        // Ezen elemek felvitele az adatbázisba
        for ($i = 0; $i < count($array); $i++) {
            DB::table("category_groups")->insertOrIgnore([
                "id" => $i+1,
                "name" => $array[$i],
                "created_at" => get_now(),
                "updated_at" => get_now()
            ]);
        }
    }
}
