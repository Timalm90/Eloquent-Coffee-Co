@props(['product'])

<article class="bg-white shadow rounded p-4 flex flex-col">
    <img
        src="{{ $product->image_url }}"
        alt="{{ $product->type->type ?? 'type' }}"
        class="mb-4 rounded">

    <h3 class="text-lg font-semibold mb-2">
        {{ $product->name }}
    </h3>

    <p class="text-sm text-gray-600 mb-1">
        {{ $product->origin->country ?? 'Unknown' }},
        {{ $product->region->region ?? 'Unknown' }}
    </p>

    <p class="text-sm text-gray-600 mb-1">
        Roast: {{ $product->roast->roast ?? 'Unknown' }}
    </p>

    <p class="text-sm text-gray-600 mb-1">
        Type: {{ $product->type->type ?? 'Unknown' }}
    </p>

    <p class="mt-auto font-semibold">
        @if($product->in_stock)
        ✅ In stock
        @else
        ❌ Out of stock
        @endif
    </p>
</article>