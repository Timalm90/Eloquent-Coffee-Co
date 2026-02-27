<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Origin;
use App\Models\Suffix;
use App\Models\Roast;
use App\Models\Type;
use Faker\Factory as Faker;
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
        $this->call([
            OriginSeeder::class,
            RegionSeeder::class,
            SuffixSeeder::class,
            RoastSeeder::class,
            TypeSeeder::class,
            UserSeeder::class
        ]);

        $faker = Faker::create();

        $origins = Origin::with('regions')->get();
        $suffixes = Suffix::all();
        $roasts = Roast::all();
        $types = Type::all();

        $generated = [];
        $attempts = 0;
        $maxAttempts = 200;
        $target = 100;

        while (count($generated) < $target && $attempts < $maxAttempts) {
            $attempts++;

            $origin = $origins->random();

            if ($origin->regions->isEmpty()) {
                continue;
            }

            $region = $origin->regions->random();
            $suffix = $suffixes->random();

            $name = "{$origin->country} {$region->region} {$suffix->suffix}";

            if (in_array($name, $generated, true)) {
                continue; // already generated, try again
            }

            $generated[] = $name;

            Product::create([
                'name'       => $name,
                'country_id' => $origin->id,
                'region_id'  => $region->id,
                'suffix_id'  => $suffix->id,
                'roast_id'   => $roasts->random()->id,
                'type_id'    => $types->random()->id,
                'in_stock'   => $faker->boolean(80),
            ]);
        }

        $this->command->info('Created ' . count($generated) . " products after {$attempts} attempts.");
    }
}
