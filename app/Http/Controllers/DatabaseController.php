<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Origin;
use App\Models\Region;
use App\Models\Suffix;
use App\Models\Roast;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['origin', 'region', 'roast', 'type']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('country')) {
            $query->where('country_id', $request->country);
        }

        if ($request->filled('region')) {
            $query->where('region_id', $request->region);
        }

        if ($request->filled('roast')) {
            $query->where('roast_id', $request->roast);
        }

        if ($request->filled('type')) {
            $query->where('type_id', $request->type);
        }

        $products = $query->paginate(20)->withQueryString();

        // If this is an AJAX request, return only the products table partial (HTML)
        if ($request->ajax()) {
            return view('dashboard._products_table', [
                'products' => $products,
            ]);
        }

        return view('dashboard', [
            'products' => $products,
            'countries' => Origin::all(),
            'regions' => Region::all(),
            'suffixes' => Suffix::all(),
            'roasts' => Roast::all(),
            'types' => Type::all(),
        ]);
    }

    public function create()
    {
        return view('dashboard.products.create', [
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
            'roast_id' => 'required|exists:roasts,id',
            'type_id' => 'required|exists:types,id',
            'inventory' => 'nullable|integer|min:0',
            'price' => 'nullable|integer|min:0',
        ]);

        $data['inventory'] = $data['inventory'] ?? 0;
        $data['price'] = $data['price'] ?? 0;
        $data['suffix_id'] = Suffix::inRandomOrder()->value('id');

        Product::create($data);

        return redirect()->route('dashboard.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('dashboard.products.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        return view('dashboard.products.edit', [
            'product' => $product,
            'countries' => Origin::all(),
            'regions' => Region::all(),
            'suffixes' => Suffix::all(),
            'roasts' => Roast::all(),
            'types' => Type::all(),
        ]);
    }

    public function updatePrice(Request $request, Product $product)
    {
        $data = $request->validate([
            'price' => 'required|numeric|min:0'
        ]);

        $product->update(['price' => $data['price']]);

        return back()->with('success', 'Price updated.');
    }

    public function addInventory(Request $request, Product $product)
    {
        $data = $request->validate(['incoming' => 'required|integer|min:1']);

        $product->update(['inventory' => $product->inventory + $data['incoming']]);

        return back()->with('success', 'Inventory updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function regionsByCountry($countryId)
    {
        $regions = Region::where('country_id', $countryId)->get();
        return response()->json($regions);
    }

    public function setInventory(Request $request, Product $product)
    {
        $data = $request->validate([
            'new_count' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($product, $data) {
            $p = Product::where('id', $product->id)->lockForUpdate()->first();
            $p->inventory = $data['new_count'];
            $p->save();
        });

        return back()->with('success', 'Inventory updated.');
    }
}
