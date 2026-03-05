<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:origins,id',
            'region' => 'required|string|max:255',
        ]);

        Region::create([
            'country_id' => $request->country_id,
            'region' => $request->region,
        ]);

        return back()->with('success', 'Region added.');
    }
}
