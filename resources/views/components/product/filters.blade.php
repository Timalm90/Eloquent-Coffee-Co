@props([
'filters',
'roasts',
'types',
'countries',
'mode' => 'customer' //default
])

<div
    x-data="'{{ $mode }}' === 'dashboard'
    ? filterComponentDashboard(@js($filters))
    : filterComponentCustomer(@js($filters))"
    class="flex flex-wrap gap-4 mb-6 items-center">

    {{-- Roast --}}
    <select x-model="filters.roast" @change="updateFilters()" class="border rounded px-3 py-2">
        <option value="">All Roasts</option>
        @foreach ($roasts as $roast)
        <option value="{{ $roast->id }}">
            {{ $roast->roast }}
        </option>
        @endforeach
    </select>

    {{-- Type --}}
    <select x-model="filters.type" @change="updateFilters()" class="border rounded px-3 py-2">
        <option value="">All Types</option>
        @foreach ($types as $type)
        <option value="{{ $type->id }}">
            {{ $type->type }}
        </option>
        @endforeach
    </select>

    {{-- Country --}}
    <select x-model="filters.country" @change="updateFilters()" class="border rounded px-3 py-2">
        <option value="">All Countries</option>
        @foreach ($countries as $country)
        <option value="{{ $country->id }}">
            {{ $country->country }}
        </option>
        @endforeach
    </select>

    {{-- In Stock Toggle (Customer Only) --}}
    @if($mode === 'customer')
    <div class="flex items-center gap-2">
        <span class="text-sm text-gray-600">Toggle out of stock</span>

        <div
            @click="filters.in_stock = filters.in_stock === '1' ? 'all' : '1'; updateFilters()"
            :class="filters.in_stock === 'all' ? 'bg-red-900' : 'bg-green-300'"
            class="relative w-11 h-6 rounded-full cursor-pointer transition-colors duration-200">
            <div
                :class="filters.in_stock === 'all' ? 'translate-x-5' : 'translate-x-1'"
                class="absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"></div>
        </div>
    </div>
    @endif

    {{-- Clear --}}
    <button @click="clearFilters()" class="h-16 flex items-center justify-center">
        <img
            :src="hasFilters 
        ? '/images/icons/HasFilterTrue.png' 
        : '/images/icons/HasFilterFalse.png'"
            class="h-full w-auto">
    </button>

</div>