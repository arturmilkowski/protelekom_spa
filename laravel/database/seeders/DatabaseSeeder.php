<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Artur',
            'email' => 'artur-milkowski@tlen.pl',
            'password' => Hash::make('12345678'),
        ]);

        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            ConditionSeeder::class,
            ProductSeeder::class,
            TypeSeeder::class,
        ]);
    }
}
