<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Roast;
use App\Models\Type;
use App\Models\Origin;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with([
            'origin',
            'region',
            'roast',
            'type'
        ]);

        if ($request->filled('roast')) {
            $query->where('roast_id', $request->roast);
        }

        if ($request->filled('type')) {
            $query->where('type_id', $request->type);
        }

        if ($request->filled('country')) {
            $query->where('country_id', $request->country);
        }

        $products = $query->paginate(12)->withQueryString();

        $roasts = Roast::all();
        $types = Type::all();
        $countries = Origin::all();

        return view('index', compact('products', 'roasts', 'types', 'countries'));
    }
}
