@props([
'countries',
'regions',
'roasts',
'types',
'hasProductErrors' => false,
])

<div
    id="modal-add-product"
    x-cloak
    x-show="openAddModal"
    x-trap.inert.noscroll="openAddModal"
    @click.self="openAddModal = false"
    @keydown.escape.window="openAddModal = false"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-add-product-title"
    class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-start justify-center z-[1100] overflow-y-auto py-8 px-4">

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl my-auto"
        data-regions='@json($regions->map(fn($r) => ['id'=> $r->id, 'country_id' => $r->country_id, 'region' => $r->region]))'
        x-data="{ regions: [], selectedCountry: '{{ old('country_id', '') }}', selectedRegion: '{{ old('region_id', '') }}' }"
        x-init="regions = JSON.parse($el.dataset.regions)">

        <div class="flex justify-between items-start mb-1">
            <h2 id="modal-add-product-title" class="text-xl font-semibold text-gray-900">Add Product</h2>
            <button
                type="button"
                @click="openAddModal = false"
                aria-label="Close Add Product dialog"
                class="text-gray-400 hover:text-gray-600 text-2xl leading-none focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                ×
            </button>
        </div>
        <p class="text-sm text-gray-500 mb-6">Fill in the details below to add a new product to the catalogue</p>

        @if ($hasProductErrors)
        <div role="alert" class="mb-6 p-4 rounded-lg bg-red-50 text-red-800 border border-red-200">
            <p class="text-sm font-semibold mb-2">Please fix the following errors:</p>
            <ul class="list-disc ml-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('dashboard.store') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" novalidate>
            @csrf

            <div class="flex flex-col gap-1">
                <label for="product-name" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    Product Name <span aria-hidden="true" class="text-red-500">*</span>
                    <span class="sr-only">(required)</span>
                </label>
                <input
                    id="product-name"
                    name="name"
                    placeholder="e.g., Yirgacheffe Natural"
                    value="{{ old('name') }}"
                    required
                    aria-required="true"
                    @error('name') aria-invalid="true" aria-describedby="error-name" @enderror
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('name') border-red-400 @enderror">
                @error('name')
                <p id="error-name" role="alert" class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <label for="product-country" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    Country <span aria-hidden="true" class="text-red-500">*</span>
                    <span class="sr-only">(required)</span>
                </label>
                <select
                    id="product-country"
                    name="country_id"
                    required
                    aria-required="true"
                    x-model="selectedCountry"
                    @change="selectedCountry = $event.target.value; selectedRegion = ''"
                    @error('country_id') aria-invalid="true" aria-describedby="error-country" @enderror
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('country_id') border-red-400 @enderror">
                    <option value="">-- Select country --</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                        {{ $country->country }}
                    </option>
                    @endforeach
                </select>
                @error('country_id')
                <p id="error-country" role="alert" class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <label for="product-region" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    Region <span aria-hidden="true" class="text-red-500">*</span>
                    <span class="sr-only">(required)</span>
                </label>

                <select
                    id="product-region"
                    name="region_id"
                    required
                    aria-required="true"
                    x-model="selectedRegion"
                    @error('region_id') aria-invalid="true" aria-describedby="error-region" @enderror
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('region_id') border-red-400 @enderror">
                    <option value="">-- Select region --</option>
                    <template x-for="r in regions.filter(x => !selectedCountry || String(x.country_id) === String(selectedCountry))" :key="r.id">
                        <option :value="r.id" :selected="String(selectedRegion) === String(r.id)" x-text="r.region"></option>
                    </template>
                </select>

                @error('region_id')
                <p id="error-region" role="alert" class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <label for="product-roast" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    Roast <span aria-hidden="true" class="text-red-500">*</span>
                    <span class="sr-only">(required)</span>
                </label>
                <select
                    id="product-roast"
                    name="roast_id"
                    required
                    aria-required="true"
                    @error('roast_id') aria-invalid="true" aria-describedby="error-roast" @enderror
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('roast_id') border-red-400 @enderror">
                    <option value="">-- Choose roast --</option>
                    @foreach($roasts as $roast)
                    <option value="{{ $roast->id }}" {{ old('roast_id') == $roast->id ? 'selected' : '' }}>
                        {{ $roast->roast }}
                    </option>
                    @endforeach
                </select>
                @error('roast_id')
                <p id="error-roast" role="alert" class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <label for="product-type" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    Type <span aria-hidden="true" class="text-red-500">*</span>
                    <span class="sr-only">(required)</span>
                </label>
                <select
                    id="product-type"
                    name="type_id"
                    required
                    aria-required="true"
                    @error('type_id') aria-invalid="true" aria-describedby="error-type" @enderror
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('type_id') border-red-400 @enderror">
                    <option value="">-- Choose type --</option>
                    @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->type }}
                    </option>
                    @endforeach
                </select>
                @error('type_id')
                <p id="error-type" role="alert" class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <label for="product-price" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    Price
                    <span class="sr-only">(required)</span>
                </label>
                <input
                    id="product-price"
                    name="price"
                    type="number"
                    step="0.01"
                    min="0"
                    value="{{ old('price') }}"
                    placeholder="0"
                    required
                    aria-required="true"
                    @error('price') aria-invalid="true" aria-describedby="error-price" @enderror
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('price') border-red-400 @enderror">
                @error('price')
                <p id="error-price" role="alert" class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <label for="product-inventory" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    Inventory
                    <span class="sr-only">(required)</span>
                </label>
                <input
                    id="product-inventory"
                    name="inventory"
                    type="number"
                    min="0"
                    value="{{ old('inventory') }}"
                    placeholder="0"
                    required
                    aria-required="true"
                    @error('inventory') aria-invalid="true" aria-describedby="error-inventory" @enderror
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('inventory') border-red-400 @enderror">
                @error('inventory')
                <p id="error-inventory" role="alert" class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-full flex gap-3 pt-2 border-t border-gray-100 mt-2">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    Add Product
                </button>
                <button
                    type="button"
                    @click="openAddModal = false"
                    class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors duration-200">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>