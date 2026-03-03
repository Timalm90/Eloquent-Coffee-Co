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
    public function index(Request $request)
    {
        $query = Product::with(['origin', 'region', 'roast', 'type']);

        // Filter by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by country
        if ($request->filled('country')) {
            $query->where('country_id', $request->country);
        }

        // Filter by region
        if ($request->filled('region')) {
            $query->where('region_id', $request->region);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type_id', $request->type);
        }

        $products = $query->paginate(20)->withQueryString();

        return view('dashboard', [
            'products' => $products,
            'countries' => Origin::all(),
            'regions' => Region::all(),
            'suffixes' => Suffix::all(),
            'roasts' => Roast::all(),
            'types' => Type::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'country_id' => 'required|exists:origins,id',
            'region_id' => 'required|exists:regions,id',
            'suffix_id' => 'required|exists:suffixes,id',
            'roast_id' => 'required|exists:roasts,id',
            'type_id' => 'required|exists:types,id',
            'inventory' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
        ]);

        Product::create($data);

        return redirect()->route('dashboard.index')
            ->with('success', 'Product created successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'inventory' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
        ]);

        $product->update($data);

        return redirect()->back()
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()
            ->with('success', 'Product deleted successfully.');
    }
}
