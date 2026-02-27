<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::get('/', [ProductController::class, 'index']);

Route::get('/test-products', function () {
    $products = Product::with(['origin', 'region', 'suffix', 'roast', 'type'])->get();
    return view('test-products', compact('products'));
});

Route::get('/products', [ProductController::class, 'index']);
