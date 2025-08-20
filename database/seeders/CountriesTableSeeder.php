<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            ['name' => 'مصر', 'active' => 1],
            ['name' => 'كندا', 'active' => 1],
            ['name' => 'أمريكا', 'active' => 1],
            ['name' => 'الامارات', 'active' => 1],
            ['name' => 'قطر', 'active' => 1],
            ['name' => 'المكسيك', 'active' => 1],
            ['name' => 'السعودية', 'active' => 1],
            ['name' => 'المغرب', 'active' => 1],
            ['name' => 'ليبيا', 'active' => 1],
            ['name' => 'لبنان', 'active' => 1],
            ['name' => 'اليمن', 'active' => 1],
            ['name' => 'انجلترا', 'active' => 1],
        ]);
    }
}
