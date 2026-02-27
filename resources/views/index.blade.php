<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50 p-6">

    <div class="max-w-7xl mx-auto">

        <h1 class="text-3xl font-bold mb-6">Products</h1>

        {{-- Filters --}}
        <div x-data="filterComponent()" class="flex flex-wrap gap-4 mb-6 items-center">

            {{-- Roast --}}
            <select x-model="filters.roast" @change="updateFilters()" class="border rounded px-3 py-2">
                <option value="">All Roasts</option>
                @foreach ($roasts as $roast)
                <option value="{{ $roast->id }}" :selected="filters.roast == '{{ $roast->id }}'">
                    {{ $roast->roast }}
                </option>
                @endforeach
            </select>

            {{-- Type --}}
            <select x-model="filters.type" @change="updateFilters()" class="border rounded px-3 py-2">
                <option value="">All Types</option>
                @foreach ($types as $type)
                <option value="{{ $type->id }}" :selected="filters.type == '{{ $type->id }}'">
                    {{ $type->type }}
                </option>
                @endforeach
            </select>

            {{-- Country --}}
            <select x-model="filters.country" @change="updateFilters()" class="border rounded px-3 py-2">
                <option value="">All Countries</option>
                @foreach ($countries as $country)
                <option value="{{ $country->id }}" :selected="filters.country == '{{ $country->id }}'">
                    {{ $country->country }}
                </option>
                @endforeach
            </select>

            {{-- In Stock Toggle --}}
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Toggle out of stock</span>
                <div
                    @click="filters.in_stock = filters.in_stock == '1' ? 'all' : '1'; updateFilters()"
                    :class="filters.in_stock == 'all' ? 'bg-red-900' : 'bg-green-300'"
                    class="relative w-11 h-6 rounded-full cursor-pointer transition-colors duration-200">
                    <div
                        :class="filters.in_stock == 'all' ? 'translate-x-5' : 'translate-x-1'"
                        class="absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200">
                    </div>
                </div>
            </div>

            <button @click="clearFilters()" class="bg-red-500 text-white px-3 py-2 rounded">Clear Filters</button>
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
            <div class="card bg-white shadow rounded p-4 flex flex-col">
                <img src="{{ $product->image_url }}" alt="{{ $product->type->type ?? 'type' }}" class="mb-4 rounded">
                <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                <p class="text-sm text-gray-600 mb-1">
                    {{ $product->origin->country ?? 'Unknown' }},
                    {{ $product->region->region ?? 'Unknown' }}
                </p>
                <p class="text-sm text-gray-600 mb-1">Roast: {{ $product->roast->roast ?? 'Unknown' }}</p>
                <p class="text-sm text-gray-600 mb-1">Type: {{ $product->type->type ?? 'Unknown' }}</p>
                <p class="mt-auto font-semibold">
                    @if($product->in_stock)
                    ✅ In stock
                    @else
                    ❌ Out of stock
                    @endif
                </p>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $products->links() }}
        </div>

    </div>

    <script>
        function filterComponent() {
            return {
                filters: {
                    roast: '{{ request("roast") }}',
                    type: '{{ request("type") }}',
                    country: '{{ request("country") }}',
                    in_stock: '{{ request("in_stock", "1") }}',
                },
                updateFilters() {
                    const params = new URLSearchParams(this.filters);
                    window.location.href = `/?${params.toString()}`;
                },
                clearFilters() {
                    this.filters = {
                        roast: '',
                        type: '',
                        country: '',
                        in_stock: '1'
                    };
                    window.location.href = '/';
                }
            }
        }
    </script>
</body>

</html>