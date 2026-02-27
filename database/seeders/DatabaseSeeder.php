<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        class DatabaseSeeder extends Seeder
        {
            public function run()
            {
                $this->call([
                    OriginSeeder::class,
                    RegionSeeder::class,
                    SuffixSeeder::class,
                    RoastSeeder::class,
                    TypeSeeder::class,
                ]);

                Product::factory()->count(100)->create();
            }
        }


        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
