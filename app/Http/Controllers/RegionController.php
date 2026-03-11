<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class RegionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:origins,id',
            'region' => [
                'required',
                'string',
                'max:255',
                'unique:regions,region,NULL,id,country_id,' . $request->country_id
            ],
        ], [
            'region.unique' => 'This region already exists for the selected country.',
        ]);

        Region::create([
            'country_id' => $request->country_id,
            'region' => $request->region,
        ]);

        return back()->with('success', 'Region added successfully.');
    }

    // TEST: Remove region from database (if it has no products linked to it)
    public function destroy(Region $region)
    {
        if ($region->products()->exists()) {
            return redirect()->back()
                ->with('error', "Can't remove this region since it has registered products");
        }

        try {
            $region->delete();
        } catch (QueryException $e) {
            return redirect()->back()->with('error', "Can't remove from database — there are related records.");
        }

        return redirect()->back()->with('success', 'Region removed.');
    }
}
