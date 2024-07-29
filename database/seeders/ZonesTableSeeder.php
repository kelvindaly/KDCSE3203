<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ZonesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('zones')->insert([
            ['zone_name' => 'Zone 1', 'flat_rate' => 10.00],
            ['zone_name' => 'Zone 2', 'flat_rate' => 15.00],
            ['zone_name' => 'Zone 3', 'flat_rate' => 20.00],
        ]);
    }
}
