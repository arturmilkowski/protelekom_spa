<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'id' => 1,
            'product_id' => 1,
            'condition_id' => 1,
            'slug' => 'mietowy',
            'name' => 'Miętowy',
            'price' => 4999.00,
            'promo_price' => 3999.00,
            'quantity' => 1,
            'hide' => false,
            'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Atque magni molestiae molestias expedita nam necessitatibus quia optio minus quam sapiente ab laborum iure deleniti excepturi, voluptate nostrum a laudantium aut?',
        ]);
    }
}
