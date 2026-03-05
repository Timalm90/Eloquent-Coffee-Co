<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-50 p-6">
    <x-header />

    <div class="max-w-7xl mx-auto">

        <h1 class="text-3xl font-bold mb-6">Products</h1>

        <div
            x-data="filterComponentCustomer({
                roast: '{{ request('roast') }}',
                type: '{{ request('type') }}',
                country: '{{ request('country') }}',
                in_stock: '{{ request('in_stock', '1') }}'
            })">

            <x-product.filters
                :filters="[
                    'roast' => request('roast'),
                    'type' => request('type'),
                    'country' => request('country'),
                    'in_stock' => request('in_stock', '1')
                ]"
                :roasts="$roasts"
                :types="$types"
                :countries="$countries" 
                mode="customer"
                />

        </div>

        <x-product.grid :products="$products" />

        <div class="mt-6">
            {{ $products->links() }}
        </div>

    </div>
</body>