<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'origin',
            'region',
            'roast',
            'type'
        ])->paginate(12);

        return view('index', compact('products'));
    }
}
