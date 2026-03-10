@props(['product'])

<article
    class="bg-white shadow-sm hover:shadow-lg rounded-lg overflow-hidden transition-shadow duration-300 flex flex-col h-full"
    aria-label="{{ $product->name }}">

    {{-- Product Image --}}
    <div class="relative aspect-square overflow-hidden bg-gray-100">
        <img
            src="{{ $product->image_url }}"
            alt="{{ $product->name }} — {{ $product->origin->country ?? 'Unknown' }}, {{ $product->region->region ?? 'Unknown' }}"
            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">

        {{-- Stock Badge --}}
        @if(!$product->in_stock)
        <div class="absolute top-3 right-3" aria-label="Out of stock">
            <span class="bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                Out of Stock
            </span>
        </div>
        @endif
    </div>

    {{-- Product Details --}}
    <div class="p-5 flex flex-col flex-grow">

        {{-- Product Name --}}
        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
            {{ $product->name }}
        </h3>

        {{-- Origin --}}
        <div class="flex items-center text-sm text-gray-600 mb-2">
            <svg
                class="w-4 h-4 mr-1 shrink-0"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                aria-hidden="true"
                focusable="false">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>{{ $product->origin->country ?? 'Unknown' }}, {{ $product->region->region ?? 'Unknown' }}</span>
        </div>

        {{-- Product Details --}}
        <dl class="space-y-1 mb-4 text-sm">
            <div class="flex justify-between">
                <dt class="text-gray-500">Roast:</dt>
                <dd class="font-medium text-gray-900">{{ $product->roast->roast ?? 'Unknown' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Type:</dt>
                <dd class="font-medium text-gray-900">{{ $product->type->type ?? 'Unknown' }}</dd>
            </div>
        </dl>

        <div class="flex-grow"></div>

        {{-- Price --}}
        <div class="pt-4 border-t border-gray-100">
            <p class="text-center font-bold text-gray-900">
                <span class="sr-only">Price:</span>
                ${{ number_format($product->price, 2) }}
            </p>
        </div>

    </div>
</article>