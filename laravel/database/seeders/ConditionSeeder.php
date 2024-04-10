<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('conditions')->insert([
            'id' => 1,
            'slug' => 'nowy',
            'name' => 'Nowy'
        ]);
        DB::table('conditions')->insert([
            'id' => 2,
            'slug' => 'uzywany',
            'name' => 'Używany'
        ]);
    }
}
