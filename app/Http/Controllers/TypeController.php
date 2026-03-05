<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

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
}
