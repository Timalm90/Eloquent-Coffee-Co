@props([
'filters',
'roasts',
'types',
'countries',
'regions' => collect(),
'mode' => 'customer'
])

<div
    x-data="'{{ $mode }}' === 'dashboard'
    ? filterComponentDashboard(@js($filters))
    : filterComponentCustomer(@js($filters))"
    data-regions='@json($regions->map(fn($r) => ['id' => $r->id, 'country_id' => $r->country_id, 'region' => $r->region]))'
    x-init="regions = JSON.parse($el.dataset.regions || '[]')"
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
            <option value="{{ $roast->id }}" {{ isset($filters['roast']) && $filters['roast'] == $roast->id ? 'selected' : '' }}>
                {{ $roast->roast }}
            </option>
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
            <option value="{{ $type->id }}" {{ isset($filters['type']) && $filters['type'] == $type->id ? 'selected' : '' }}>
                {{ $type->type }}
            </option>
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
            <option value="{{ $country->id }}" {{ isset($filters['country']) && $filters['country'] == $country->id ? 'selected' : '' }}>
                {{ $country->country }}
            </option>
            @endforeach
        </select>
    </div>

    {{-- Region (Dashboard Only) --}}
    @if($mode === 'dashboard')
    <div class="flex flex-col gap-1">
        <label for="filter-region" class="sr-only">Filter by region</label>
        <select
            id="filter-region"
            x-model="filters.region"
            @change="updateFilters()"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
            <option value="">All Regions</option>
            <template x-for="r in regions.filter(r => !filters.country || String(r.country_id) === String(filters.country))" :key="r.id">
                <option :value="r.id" x-text="r.region"></option>
            </template>
        </select>
    </div>
    @endif

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