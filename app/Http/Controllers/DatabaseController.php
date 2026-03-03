<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Could we use this to display the products in index page and admin page?
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([]);
        $product = new Product();
        $product->country_id = $request->integer('country_id');
        $product->origin_id = $request->integer('origin_id');
        $product->suffix_id = $request->integer('suffix_id');
        $product->roast_id = $request->integer('roast_id');
        $product->type_id = $request->integer('type_id');
        $product->inventory = $request->integer('inventory');
        $product->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'inventory' => 'required|integer'
        ]);
        $product->update([
            'inventory' => $data['inventory']
        ]);
        return redirect()->back()->with('success', 'Inventory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return redirect("/dashboard");
    }
}
