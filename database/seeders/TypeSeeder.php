<?php

namespace Database\Seeders;

use App\Models\Suffix;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Whole bean', 'Capsules', 'Ground'];

        foreach ($types as $type) {
            Suffix::create(['type' => $type]);
        }
    }
}
