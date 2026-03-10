<?php

use App\Http\Controllers\CountryController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RoastController;
use App\Http\Controllers\TypeController;

// Public pages
Route::get('/', [ProductController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);

Route::get('/test-products', function () {
    $products = Product::with(['origin', 'region', 'suffix', 'roast', 'type'])->get();
    return view('test-products', compact('products'));
});

// Auth
Route::view('/login', 'login')->name('login')->middleware('guest');
Route::post('/login', LoginController::class);
Route::get('/logout', LogoutController::class);

// Dashboard (ALLA routes ska gå till DatabaseController)
Route::middleware(['auth'])->group(function () {

    // Dashboard index
    Route::get('/dashboard', [DatabaseController::class, 'index'])
        ->name('dashboard.index');

    // Create new product
    Route::post('/dashboard', [DatabaseController::class, 'store'])
        ->name('dashboard.store');

    // Update price
    Route::put('/dashboard/{product}/price', [DatabaseController::class, 'updatePrice'])
        ->name('dashboard.updatePrice');

    // Add inventory
    Route::post('/dashboard/{product}/inventory', [DatabaseController::class, 'addInventory'])
        ->name('dashboard.addInventory');

    // Delete product
    Route::delete('/dashboard/{product}', [DatabaseController::class, 'destroy'])
        ->name('dashboard.destroy');

    // Add products - get regions for each country
    Route::get('/regions-by-country/{country}', [DatabaseController::class, 'regionsByCountry']);

    // Add items in each category in database
    Route::post('/countries', [CountryController::class, 'store'])->name('countries.store');
    Route::post('/regions', [RegionController::class, 'store'])->name('regions.store');
    Route::post('/roasts', [RoastController::class, 'store'])->name('roasts.store');
    Route::post('/types', [TypeController::class, 'store'])->name('types.store');

    // Destroy routes for data categories
    Route::delete('/countries/{origin}', [CountryController::class, 'destroy'])->name('countries.destroy');
    Route::delete('/regions/{region}', [RegionController::class, 'destroy'])->name('regions.destroy');
    Route::delete('/roasts/{roast}', [RoastController::class, 'destroy'])->name('roasts.destroy');
    Route::delete('/types/{type}', [TypeController::class, 'destroy'])->name('types.destroy');

    // Set inventory mapping
    Route::put('admin/products/{product}/inventory', [DatabaseController::class, 'setInventory'])->name('admin.products.inventory.set');
});
