<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'id' => 1,
            'slug' => 'smartfony',
            'name' => 'Smartfony'
        ]);
        DB::table('categories')->insert([
            'id' => 2,
            'slug' => 'tablety',
            'name' => 'Tablety'
        ]);
    }
}
