<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Roast;
use App\Models\Type;
use App\Models\Origin;
use App\Models\Region;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['origin', 'region', 'roast', 'type']);

        if ($request->filled('roast')) $query->where('roast_id', $request->roast);
        if ($request->filled('type')) $query->where('type_id', $request->type);
        if ($request->filled('country')) $query->where('country_id', $request->country);

        $products = $query->get();

        return view('dashboard', [
            'products' => $products,
            'roasts' => Roast::all(),
            'types' => Type::all(),
            'countries' => Origin::all(),
            'regions' => Region::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'country_id' => 'required|integer',
            'region_id' => 'required|integer',
            'roast_id' => 'required|integer',
            'type_id' => 'required|integer',
            'inventory' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        Product::create($data);

        return back()->with('success', 'Product added.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'inventory' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($data);

        return back()->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }
}
