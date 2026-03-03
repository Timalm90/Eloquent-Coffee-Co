<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Origin;
use App\Models\Region;
use App\Models\Suffix;
use App\Models\Roast;
use App\Models\Type;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter on origin
        if ($request->filled('origin')) {
            $query->where('origin', $request->origin);
        }

        // Filter on region
        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        // Filter on type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Pagination: 20 products per page
        $products = $query->paginate(20)->withQueryString();

        return view('dashboard.products.index', compact('products'));
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
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'country_id' => 'required|exists:origins,id',
            'region_id' => 'required|exists:regions,id',
            'suffix_id' => 'required|exists:suffixes,id',
            'roast_id' => 'required|exists:roasts,id',
            'type_id' => 'required|exists:types,id',
            'inventory' => 'nullable|integer|min:0',
        ]);

        $product = new Product();
        $product->name = $data['name'];
        $product->country_id = $data['country_id'];
        $product->region_id = $data['region_id'];
        $product->suffix_id = $data['suffix_id'];
        $product->roast_id = $data['roast_id'];
        $product->type_id = $data['type_id'];
        $product->inventory = $data['inventory'] ?? 0;
        $product->save();

        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', ['product' => $product]);
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
     * Only updates inventory
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'inventory' => 'required|integer',
        ]);

        $product->inventory = $product->inventory + $data['inventory'];
        $product->save();

        return redirect()->back()->with('success', 'Inventory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect("/dashboard");
    }
}
