<?php

namespace App\Http\Controllers;

use App\Models\Roast;
use Illuminate\Http\Request;

class RoastController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'roast' => 'required|string|max:255',
        ]);

        Roast::create([
            'roast' => $request->roast,
        ]);

        return back()->with('success', 'Roast added.');
    }
}
