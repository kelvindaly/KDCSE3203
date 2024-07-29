<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ZonesTableSeeder::class,
            PackagePrioritiesTableSeeder::class,
            PackageSizesTableSeeder::class,
        ]);
    }
}

