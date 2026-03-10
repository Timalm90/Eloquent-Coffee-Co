@props([
'countries',
'regions',
'roasts',
'types',
])

<div
    x-cloak
    x-show="openRemoveDataModal"
    @click.self="openRemoveDataModal = false"
    class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-lg shadow-lg w-[60vw] max-h-[80vh] overflow-y-auto"
        data-regions='@json($regions->map(fn($r) => [' id'=> $r->id, 'country_id' => $r->country_id, 'region' => $r->region]))'
        x-data="{ category: '', selectedCountry: '', selectedRegion: '', selectedRoast: '', selectedType: '', regions: [] }"
        x-init="regions = JSON.parse($el.dataset.regions)">

        <h2 class="text-xl font-semibold text-gray-900 mb-1">Remove Data</h2>
        <p class="text-sm text-gray-500 mb-6">Permanently remove countries, regions, roasts, or types from the catalogue</p>

        <div class="flex flex-col gap-1 mb-6">
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Category</label>
            <select x-model="category" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                <option value="">-- Choose category --</option>
                <option value="country">Country and/or Region</option>
                <option value="roast">Roast</option>
                <option value="type">Type</option>
            </select>
        </div>

        {{-- COUNTRY DELETE --}}
        <div x-show="category === 'country'">
            <form :action="selectedRegion ? `/regions/${selectedRegion}` : `/countries/${selectedCountry}`" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex flex-col gap-1 mb-4">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Country</label>
                    <select x-model="selectedCountry" @change="selectedRegion = ''" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                        <option value="">-- Choose country --</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->country }}</option>
                        @endforeach
                    </select>
                </div>

                <template x-if="selectedCountry">
                    <div class="flex flex-col gap-1 mb-4">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Region <span class="font-normal normal-case text-gray-400">(optional — leave blank to target the whole country)</span></label>
                        <select x-model="selectedRegion" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                            <option value="">-- No region selected --</option>
                            <template x-for="r in regions.filter(x => String(x.country_id) === String(selectedCountry))" :key="r.id">
                                <option :value="r.id" x-text="r.region"></option>
                            </template>
                        </select>
                    </div>
                </template>

                <p class="text-xs text-gray-400 mb-6">Selecting a region removes only that region. Selecting only a country will trigger controller-level checks before deletion.</p>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" :disabled="!selectedCountry"
                        class="px-4 py-2.5 bg-white hover:bg-red-50 text-red-600 text-sm font-medium rounded-lg border border-red-200 hover:border-red-300 transition-colors duration-200 disabled:opacity-40 disabled:cursor-not-allowed">
                        Delete
                    </button>
                    <button type="button" @click="openRemoveDataModal = false"
                        class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        {{-- ROAST DELETE --}}
        <div x-show="category === 'roast'">
            <form :action="`/roasts/${selectedRoast}`" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex flex-col gap-1 mb-6">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Roast</label>
                    <select x-model="selectedRoast" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                        <option value="">-- Choose roast --</option>
                        @foreach($roasts as $roast)
                        <option value="{{ $roast->id }}">{{ $roast->roast }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" :disabled="!selectedRoast"
                        class="px-4 py-2.5 bg-white hover:bg-red-50 text-red-600 text-sm font-medium rounded-lg border border-red-200 hover:border-red-300 transition-colors duration-200 disabled:opacity-40 disabled:cursor-not-allowed">
                        Delete Roast
                    </button>
                    <button type="button" @click="openRemoveDataModal = false"
                        class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        {{-- TYPE DELETE --}}
        <div x-show="category === 'type'">
            <form :action="`/types/${selectedType}`" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex flex-col gap-1 mb-6">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Type</label>
                    <select x-model="selectedType" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                        <option value="">-- Choose type --</option>
                        @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" :disabled="!selectedType"
                        class="px-4 py-2.5 bg-white hover:bg-red-50 text-red-600 text-sm font-medium rounded-lg border border-red-200 hover:border-red-300 transition-colors duration-200 disabled:opacity-40 disabled:cursor-not-allowed">
                        Delete Type
                    </button>
                    <button type="button" @click="openRemoveDataModal = false"
                        class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        {{-- Placeholder when no category selected --}}
        <div x-show="category === ''" class="py-8 text-center text-sm text-gray-400">
            Select a category above to get started
        </div>

    </div>
</div>