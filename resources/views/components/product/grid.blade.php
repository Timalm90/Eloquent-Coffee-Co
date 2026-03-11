@props(['products'])

<section aria-labelledby="products-heading">
    <h2 id="products-heading" class="sr-only">Products</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
        <div class="flex justify-center sm:block h-full">
            <div class="w-full max-w-xs sm:max-w-none h-full">
                <x-product.card :product="$product" />
            </div>
        </div>
        @endforeach
    </div>
</section>