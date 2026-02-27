<?php

namespace Database\Seeders;

use App\Models\Roast;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roasts = ['Light Roast', 'Medium Roast', 'Dark Roast', 'Espresso Roast'];

        foreach ($roasts as $roast) {
            Roast::create(['type' => $roast]);
        }
    }
}
