<?php

namespace App\Http\Controllers;

use App\Models\Roast;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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

    // TEST: Remove roast level from database (if it has no products linked to it)
    public function destroy(Roast $roast)
    {
        if ($roast->products()->exists()) {
            return redirect()->back()->with('error', "Can't remove this roast since it has registered products");
        }

        try {
            $roast->delete();
        } catch (QueryException $e) {
            return redirect()->back()->with('error', "Can't remove from database — there are related records");
        }

        return redirect()->back()->with('success', 'Roast removed.');
    }
}
