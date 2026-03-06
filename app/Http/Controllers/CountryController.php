<?php

namespace App\Http\Controllers;

use App\Models\Origin;
use App\Models\Region;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:255',
            'regions' => 'required|array|min:1',
            'regions.*' => 'nullable|string|max:255',
        ], [
            'regions.required' => 'Please add at least one region.',
            'regions.min' => 'Please add at least one region.',
        ]);

        // Filter out empty regions
        $filledRegions = array_filter($request->regions, fn($region) => !empty(trim($region)));

        if (empty($filledRegions)) {
            return back()->withErrors(['regions' => 'Please add at least one region.']);
        }

        // Check if country already exists
        $countryExists = Origin::where('country', $request->country)->exists();
        $country = Origin::firstOrCreate(
            ['country' => $request->country]
        );

        // Track how many regions were added
        $regionsAdded = 0;

        // Create the regions
        foreach ($filledRegions as $regionName) {
            $region = Region::where('country_id', $country->id)
                ->where('region', trim($regionName))
                ->first();

            if (!$region) {
                Region::create([
                    'country_id' => $country->id,
                    'region' => trim($regionName),
                ]);
                $regionsAdded++;
            }
        }

        // Determine the appropriate success message
        if ($countryExists && $regionsAdded > 0) {
            $message = $regionsAdded === 1
                ? '1 region added to existing country.'
                : "{$regionsAdded} regions added to existing country.";
        } elseif ($countryExists && $regionsAdded === 0) {
            $message = 'No new regions were added (regions already exist).';
        } else {
            $message = 'Country and regions added successfully.';
        }

        return back()->with('success', $message);
    }
}
