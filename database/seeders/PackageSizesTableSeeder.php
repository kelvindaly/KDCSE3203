<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSizesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('package_sizes')->insert([
            ['size_range' => '1-5 lbs', 'size_rate' => 5.00],
            ['size_range' => '6-10 lbs', 'size_rate' => 10.00],
            ['size_range' => '11-20 lbs', 'size_rate' => 15.00],
        ]);
    }
}
