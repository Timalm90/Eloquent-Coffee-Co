<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TypeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
        ]);

        Type::create([
            'type' => $request->type,
        ]);

        return back()->with('success', 'Type added.');
    }

    // TEST: Remove type of coffee from database (if it has no products linked to it)
    public function destroy(Type $type)
    {
        if ($type->products()->exists()) {
            return redirect()->back()->with('error', "Can't remove this type since it has registered products");
        }

        try {
            $type->delete();
        } catch (QueryException $e) {
            return redirect()->back()->with('error', "Can't remove from database — there are related records.");
        }

        return redirect()->back()->with('success', 'Type removed.');
    }
}
