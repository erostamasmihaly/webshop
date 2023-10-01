<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategoryGroupSeeder::class,
            CategorySeeder::class,
            ShopSeeder::class,
            ProductSeeder::class,
            SimplePayErrorSeeder::class,
            InteractionSeeder::class
        ]);
    }
}
