<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/test-products', function () {
    $products = Product::with(['origin', 'region', 'suffix', 'roast', 'type'])->get();
    return view('test-products', compact('products'));
});
