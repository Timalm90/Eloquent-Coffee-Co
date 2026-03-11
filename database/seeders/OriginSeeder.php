<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Origin;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = ["Brazil", "Colombia", "Guatemala", "Peru", "Costa Rica", "El Salvador", "Nicaragua", "Ethiopia", "Kenya", "Tanzania", "Indonesia", "India", "Papua New Guinea"];

        foreach ($countries as $country) {
            Origin::create(['country' => $country]);
        }
    }
}
