<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;


Route::get('/', [ProductController::class, 'index']);

Route::get('/test-products', function () {
    $products = Product::with(['origin', 'region', 'suffix', 'roast', 'type'])->get();
    return view('test-products', compact('products'));
});

Route::get('/products', [ProductController::class, 'index']);

Route::view('/login', 'login')->name('login')->middleware('guest');
Route::post('/login', LoginController::class);
Route::get('dashboard', DashboardController::class)->middleware('auth');
Route::get("/logout", LogoutController::class);
