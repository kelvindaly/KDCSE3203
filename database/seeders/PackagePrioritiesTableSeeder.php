<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackagePrioritiesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('package_priorities')->insert([
            ['priority_name' => '3 Hour', 'priority_rate' => 0.00],
            ['priority_name' => 'Same Day', 'priority_rate' => 5.00],
            ['priority_name' => 'Overnight', 'priority_rate' => 10.00],
        ]);
    }
}
