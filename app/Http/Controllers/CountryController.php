<?php

namespace App\Http\Controllers;

use App\Models\Origin;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:255',
        ]);

        Origin::create([
            'country' => $request->country,
        ]);

        return back()->with('success', 'Country added.');
    }
}
