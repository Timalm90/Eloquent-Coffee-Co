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
            return back()
                ->withInput()
                ->withErrors(['regions' => 'Please add at least one region.']);
        }

        // Get or create country
        $countryExists = Origin::where('country', $request->country)->exists();
        $country = Origin::firstOrCreate(['country' => $request->country]);

        // Check for duplicate region names WITHIN THIS COUNTRY
        $duplicateRegions = [];
        foreach ($filledRegions as $regionName) {
            $trimmedRegion = trim($regionName);
            if (Region::where('region', $trimmedRegion)
                ->where('country_id', $country->id)
                ->exists()
            ) {
                $duplicateRegions[] = $trimmedRegion;
            }
        }

        if (!empty($duplicateRegions)) {
            $duplicateList = implode(', ', $duplicateRegions);
            return back()
                ->withInput()
                ->withErrors([
                    'regions' => "The following region(s) already exist in {$country->country}: {$duplicateList}."
                ]);
        }

        // Create the regions
        $regionsAdded = 0;
        foreach ($filledRegions as $regionName) {
            Region::create([
                'country_id' => $country->id,
                'region' => trim($regionName),
            ]);
            $regionsAdded++;
        }

        // Success message
        if ($countryExists && $regionsAdded > 0) {
            $message = $regionsAdded === 1
                ? '1 region added to existing country.'
                : "{$regionsAdded} regions added to existing country.";
        } else {
            $message = 'Country and regions added successfully.';
        }

        return back()->with('success', $message);
    }
}
