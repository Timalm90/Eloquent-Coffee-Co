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
        $query = Product::with(['origin', 'region', 'roast', 'type']);

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by country/origin
        if ($request->filled('country')) {
            $query->where('country_id', $request->country);
        }

        // Alternative origin filter
        // if ($request->filled('origin')) {
        //     $query->where('country_id', $request->origin);
        // }

        // Filter by region
        if ($request->filled('region')) {
            $query->where('region_id', $request->region);
        }

        // Filter by roast
        if ($request->filled('roast')) {
            $query->where('roast_id', $request->roast);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type_id', $request->type);
        }

        // Filter by in stock
        if ($request->filled('in_stock') && $request->in_stock == '1') {
            $query->where('inventory', '>', 0);
        }

        // Pagination: 20 products per page
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

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
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

        // Set default values if not provided
        $data['inventory'] = $data['inventory'] ?? 0;
        $data['price'] = $data['price'] ?? 0;

        // Auto-assign a random suffix (used internally for product naming)
        $data['suffix_id'] = Suffix::inRandomOrder()->value('id');

        Product::create($data);

        return redirect()->route('dashboard.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('dashboard.products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
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
        $data = $request->validate(
            [
                'price' => 'required|numeric|min:0'
            ]
        );

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
}
