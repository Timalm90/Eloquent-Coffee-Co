<?php

namespace Database\Factories;

use App\Models\Origin;
use App\Models\Region;
use App\Models\Roast;
use App\Models\Suffix;
use App\Models\Type;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $origin = Origin::inRandomOrder()->first();
        $region = $origin->regions()->inRandomOrder()->first();
        $suffix = Suffix::inRandomOrder()->first();
        $roast = Roast::inRandomOrder()->first();
        $type = Type::inRandomOrder()->first();

        return [
            'name' => "{$origin->country} {$region->region} {$suffix->suffix}",
            'country_id' => $origin->id,
            'region_id' => $region->id,
            'suffix_id' => $suffix->id,
            'roast_id' => $roast->id,
            'type_id' => $type->id,
            'in_stock' => $this->faker->boolean(80),
        ];
    }
}
