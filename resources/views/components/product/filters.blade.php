@props([
'filters',
'roasts',
'types',
'countries',
'mode' => 'customer'
])

<div
    x-data="'{{ $mode }}' === 'dashboard'
    ? filterComponentDashboard(@js($filters))
    : filterComponentCustomer(@js($filters))"
    class="flex flex-wrap gap-4 mb-6 items-center"
    role="search"
    aria-label="Filter products">

    {{-- Roast --}}
    <div class="flex flex-col gap-1">
        <label for="filter-roast" class="sr-only">Filter by roast</label>
        <select
            id="filter-roast"
            x-model="filters.roast"
            @change="updateFilters()"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
            <option value="">All Roasts</option>
            @foreach ($roasts as $roast)
            <option value="{{ $roast->id }}">{{ $roast->roast }}</option>
            @endforeach
        </select>
    </div>

    {{-- Type --}}
    <div class="flex flex-col gap-1">
        <label for="filter-type" class="sr-only">Filter by type</label>
        <select
            id="filter-type"
            x-model="filters.type"
            @change="updateFilters()"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
            <option value="">All Types</option>
            @foreach ($types as $type)
            <option value="{{ $type->id }}">{{ $type->type }}</option>
            @endforeach
        </select>
    </div>

    {{-- Country --}}
    <div class="flex flex-col gap-1">
        <label for="filter-country" class="sr-only">Filter by country</label>
        <select
            id="filter-country"
            x-model="filters.country"
            @change="updateFilters()"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
            <option value="">All Countries</option>
            @foreach ($countries as $country)
            <option value="{{ $country->id }}">{{ $country->country }}</option>
            @endforeach
        </select>
    </div>

    {{-- In Stock Toggle (Customer Only) --}}
    @if($mode === 'customer')
    <div class="flex items-center gap-2">
        <span id="stock-toggle-label" class="text-sm text-gray-600">Show out of stock</span>

        <div
            role="switch"
            tabindex="0"
            :aria-checked="filters.in_stock === 'all' ? 'true' : 'false'"
            aria-labelledby="stock-toggle-label"
            @click="filters.in_stock = filters.in_stock === '1' ? 'all' : '1'; updateFilters()"
            @keydown.enter.prevent="filters.in_stock = filters.in_stock === '1' ? 'all' : '1'; updateFilters()"
            @keydown.space.prevent="filters.in_stock = filters.in_stock === '1' ? 'all' : '1'; updateFilters()"
            :class="filters.in_stock === 'all' ? 'bg-zinc-800' : 'bg-zinc-300'"
            class="relative w-11 h-6 rounded-full cursor-pointer transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
            <div
                :class="filters.in_stock === 'all' ? 'translate-x-5' : 'translate-x-1'"
                class="absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"
                aria-hidden="true">
            </div>
        </div>
    </div>
    @endif

    {{-- Clear Filters --}}
    <button
        type="button"
        @click="clearFilters()"
        aria-label="Clear all filters"
        :aria-pressed="hasFilters ? 'true' : 'false'"
        class="h-16 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
        <img
            :src="hasFilters
                ? '/images/icons/HasFilterTrue.png'
                : '/images/icons/HasFilterFalse.png'"
            :alt="hasFilters ? 'Clear active filters' : 'No filters active'"
            class="h-full w-auto">
    </button>

</div>