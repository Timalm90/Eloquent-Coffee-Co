<?php

namespace Database\Factories;

use App\Models\Origin;
use App\Models\Region;
use App\Models\Roast;
use App\Models\Suffix;
use App\Models\Type;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $origin = Origin::inRandomOrder()->first();
        $region = $origin->regions()->inRandomOrder()->first();
        $suffix = Suffix::inRandomOrder()->first();
        $roast = Roast::inRandomOrder()->first();
        $type = Type::inRandomOrder()->first();

        // 80% chance of having inventory
        $inventory = $this->faker->boolean(80)
            ? $this->faker->numberBetween(1, 100)
            : 0;

        return [
            'name' => "{$origin->country} {$region->region} {$suffix->suffix}",
            'country_id' => $origin->id,
            'region_id' => $region->id,
            'suffix_id' => $suffix->id,
            'roast_id' => $roast->id,
            'type_id' => $type->id,
            'inventory' => $inventory,
            'price' => $this->faker->numberBetween(10, 50),
        ];
    }
}
