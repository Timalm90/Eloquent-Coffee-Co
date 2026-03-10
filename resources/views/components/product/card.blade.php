@props(['product'])

<article class="bg-white shadow-sm hover:shadow-lg rounded-lg overflow-hidden transition-shadow duration-300 flex flex-col h-full">

    {{-- Product Image --}}
    <div class="relative aspect-square overflow-hidden bg-gray-100">
        <img
            src="{{ $product->image_url }}"
            alt="{{ $product->name }}"
            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">

        {{-- Stock Badge --}}
        <div class="absolute top-3 right-3">
            @if(!$product->in_stock)
            <span class="bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                Out of Stock
            </span>
            @endif
        </div>
    </div>

    {{-- Product Details --}}
    <div class="p-5 flex flex-col flex-grow">

        {{-- Product Name --}}
        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
            {{ $product->name }}
        </h3>

        {{-- Origin --}}
        <div class="flex items-center text-sm text-gray-600 mb-2">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>{{ $product->origin->country ?? 'Unknown' }}, {{ $product->region->region ?? 'Unknown' }}</span>
        </div>

        {{-- Product Details Grid --}}
        <div class="space-y-1 mb-4 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Roast:</span>
                <span class="font-medium text-gray-900">{{ $product->roast->roast ?? 'Unknown' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Type:</span>
                <span class="font-medium text-gray-900">{{ $product->type->type ?? 'Unknown' }}</span>
            </div>
        </div>

        {{-- Spacer to push price to bottom --}}
        <div class="flex-grow"></div>

        {{-- Price & Add to Cart --}}
        <div class="pt-4 border-t border-gray-100">
            <div class="flex items-center justify-center">

                <div class="text-1xl font-bold text-gray-900 justify-center">${{ number_format($product->price, 2) }}</div>
            </div>
        </div>

    </div>
</article>