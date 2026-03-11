<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/favicon-light.ico" media="(prefers-color-scheme: light)">
    <link rel="icon" type="image/x-icon" href="/favicon-dark.ico" media="(prefers-color-scheme: dark)">
    <link rel="shortcut icon" href="/favicon-light.ico">
    <title>Products - Eloquent Coffee Co</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <x-header />

    <main id="main-content">
        <div class="max-w-7xl mx-auto px-6 py-12">

            {{-- Page Header --}}
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Our Coffee Collection</h1>
                <p class="text-gray-600">Discover premium coffee from around the world</p>
            </div>

            {{-- Search Bar --}}
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <form method="GET" role="search" aria-label="Search products">
                    <div class="flex gap-3 items-center">
                        <div class="flex-1">
                            <label for="search-input" class="sr-only">Search for coffee</label>
                            <input
                                id="search-input"
                                type="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search for coffee..."
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        </div>

                        {{-- Preserve existing filters --}}
                        <input type="hidden" name="roast" value="{{ request('roast') }}">
                        <input type="hidden" name="type" value="{{ request('type') }}">
                        <input type="hidden" name="country" value="{{ request('country') }}">
                        <input type="hidden" name="in_stock" value="{{ request('in_stock', '1') }}">

                        <button
                            type="submit"
                            class="px-6 py-3 bg-gray-800 hover:bg-gray-900 text-white rounded-lg transition-colors duration-200 font-medium">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            {{-- Filters --}}
            <div class="mb-8">
                <div
                    x-data="filterComponentCustomer({
                        search: '{{ request('search') }}',
                        roast: '{{ request('roast') }}',
                        type: '{{ request('type') }}',
                        country: '{{ request('country') }}',
                        in_stock: '{{ request('in_stock', '1') }}'
                    })">

                    <x-product.filters
                        :filters="[
                            'search' => request('search'),
                            'roast' => request('roast'),
                            'type' => request('type'),
                            'country' => request('country'),
                            'in_stock' => request('in_stock', '1')
                        ]"
                        :roasts="$roasts"
                        :types="$types"
                        :countries="$countries"
                        mode="customer" />
                </div>
            </div>

            {{-- Results count --}}
            <div class="mb-6 text-gray-600" aria-live="polite" aria-atomic="true">
                <p>Showing <span class="font-semibold">{{ $products->count() }}</span> of <span class="font-semibold">{{ $products->total() }}</span> products</p>
            </div>

            {{-- Product Grid --}}
            <x-product.grid :products="$products" />

            {{-- Pagination --}}
            <nav aria-label="Product pagination" class="mt-10 flex flex-col items-center gap-4">
                {{ $products->links() }}
            </nav>

        </div>
    </main>
</body>

</html>