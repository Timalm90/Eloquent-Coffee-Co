<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <h1>Products</h1>

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

    <div>
        {{ $products->links() }}
    </div>

</body>

</html>