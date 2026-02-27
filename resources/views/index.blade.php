<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    {{-- FILTER FORM --}}
    <form method="GET" class="filters">
        <select name="roast">
            <option value="">All Roasts</option>
            @foreach ($roasts as $roast)
            <option value="{{ $roast->id }}" {{ request('roast') == $roast->id ? 'selected' : '' }}>
                {{ $roast->roast }}
            </option>
            @endforeach
        </select>

        <select name="type">
            <option value="">All Types</option>
            @foreach ($types as $type)
            <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                {{ $type->type }}
            </option>
            @endforeach
        </select>

        <select name="country">
            <option value="">All Countries</option>
            @foreach ($countries as $country)
            <option value="{{ $country->id }}" {{ request('country') == $country->id ? 'selected' : '' }}>
                {{ $country->country }}
            </option>
            @endforeach
        </select>

        <button type="submit">Filter</button>
    </form>

    {{-- PRODUCTS GRID --}}
    <div class="grid">
        @foreach ($products as $product)
        <div class="card">
            <img src="{{ $product->image_url }}" alt="{{ $product->type->type ?? 'type' }}">

            <h3>{{ $product->name }}</h3>

            <p>
                {{ $product->origin->country ?? 'Unknown' }},
                {{ $product->region->region ?? 'Unknown' }}
            </p>

            <p>Roast: {{ $product->roast->roast ?? 'Unknown' }}</p>
            <p>Type: {{ $product->type->type ?? 'Unknown' }}</p>

            <p>
                @if($product->in_stock)
                ✅ In stock
                @else
                ❌ Out of stock
                @endif
            </p>
        </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div>
        {{ $products->links() }}
    </div>

</body>

</html>