<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert(
            [
                'brand_id' => 2,
                'category_id' => 1,
                'slug' => 'galaxy-z-flip5',
                'name' => 'Galaxy Z Flip5',
                'description' => 'Flex Window Największy jak dotąd ekran zewnętrzny w Galaxy Z Flip. Galaxy Z Flip5 debiutuje z 3,4-calowym ekranem Flex Window stworzonym do wyrażania siebie. Kompaktowy i przyciągający wzrok pod każdym kątem. Składany smartfon, który jest równie wszechstronny, co przenośny.',
                'img' => 'galaxy-z-flip5.jpg',
                'site_description' => 'Posiadamy telefony samsung',
                'site_keyword' => 'samsung, galaxy, flip',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        DB::table('products')->insert(
            [
                'brand_id' => 1,
                'category_id' => 1,
                'slug' => 'product-1',
                'name' => 'Product 1',
                'description' => '',
                'site_description' => '',
                'site_keyword' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
