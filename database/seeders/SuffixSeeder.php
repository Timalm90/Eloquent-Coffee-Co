<?php

namespace Database\Seeders;

use App\Models\Suffix;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuffixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suffixes = ['Reserve', 'Classic', 'Signature', 'Estate', 'Selection', 'Heritage', 'Prime', 'Gold', 'Limited'];

        foreach ($suffixes as $suffix) {
            Suffix::create(['suffix' => $suffix]);
        }
    }
}
