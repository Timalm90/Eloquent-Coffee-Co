<?php

namespace Database\Seeders;

use App\Models\Origin;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            'Brazil' => ['Santos', 'Cerrado', 'Mogiana', 'Sul de Minas'],
            'Colombia' => ['Huila', 'Nariño', 'Tolima', 'Antioquia'],
            'Guatemala' => ['Antigua', 'Huehuetenango', 'Coban', 'Atitlan'],
            'Peru' => ['Cajamarca', 'Cusco', 'Puno', 'Amazonas'],
            'Costa Rica' => ['Tarrazu', 'Central Valley', 'Brunca', 'Guanacaste'],
            'El Salvador' => ['Santa Ana', 'Ahuachapán', 'Chalatenango', 'Usulutuán'],
            'Nicaragua' => ['Matagalpa', 'Jinotega', 'Nueva Segovia', 'Boaco'],
            'Ethiopia' => ['Yirgacheffe', 'Sidamo', 'Harrar', 'Limu'],
            'Kenya' => ['Nyeri', 'Kirinyaga', 'Embu', 'Meru'],
            'Tanzania' => ['Kilimanjaro', 'Mbeya', 'Arusha', 'Moshi'],
            'Indonesia' => ['Sumatra', 'Java', 'Sulawesi', 'Bali'],
            'India' => ['Chikmagalur', 'Coorg', 'Araku Valley', 'Wayanad'],
            'Papua New Guinea' => ['Eastern Highlands', 'Western Highlands', 'Simbu', 'Morobe'],
        ];

        foreach ($regions as $country => $regionList) {
            $origin = Origin::where('country', $country)->first();

            foreach ($regionList as $region) {
                Region::create(['region' => $region, 'country_id' => $origin->id]);
            }
        }
    }
}
