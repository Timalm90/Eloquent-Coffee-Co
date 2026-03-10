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

    <div class="bg-white p-6 rounded shadow-lg w-[60vw] max-h-[80vh] overflow-y-auto"
        data-regions='@json($regions->map(fn($r) => [' id'=> $r->id, 'country_id' => $r->country_id, 'region' => $r->region]))'
        x-data="{ category: '', selectedCountry: '', selectedRegion: '', selectedRoast: '', selectedType: '', regions: [] }"
        x-init="regions = JSON.parse($el.dataset.regions)">

        <h2 class="text-xl font-bold mb-4">Remove Data</h2>

        <label class="block font-semibold mb-2">Select Category</label>
        <select x-model="category" class="border rounded p-2 w-full mb-4">
            <option value="">-- Choose category --</option>
            <option value="country">Country and/or Region</option>
            <option value="roast">Roast</option>
            <option value="type">Type</option>
        </select>

        {{-- COUNTRY DELETE --}}
        <div x-show="category === 'country'">
            <form :action="selectedRegion ? `/regions/${selectedRegion}` : `/countries/${selectedCountry}`" method="POST">
                @csrf
                @method('DELETE')

                <label class="block font-semibold mb-1">Select Country</label>
                <select x-model="selectedCountry" @change="selectedRegion = ''" class="border rounded p-2 w-full mb-4">
                    <option value="">-- Choose country --</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                    @endforeach
                </select>

                <template x-if="selectedCountry">
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Optional: Select Region to delete only that region</label>
                        <select x-model="selectedRegion" class="border rounded p-2 w-full">
                            <option value="">-- No region selected --</option>
                            <template x-for="r in regions.filter(x => String(x.country_id) === String(selectedCountry))" :key="r.id">
                                <option :value="r.id" x-text="r.region"></option>
                            </template>
                        </select>
                    </div>
                </template>

                <p class="text-sm text-gray-600 mb-4">If you select a region the region will be deleted. If you only select country, the controller will run checks and delete the country if allowed.</p>
                <div class="flex gap-3">
                    <button type="submit" :disabled="!selectedCountry" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                    <button type="button" @click="openRemoveDataModal = false" class="bg-gray-400 px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>

        {{-- ROAST DELETE --}}
        <div x-show="category === 'roast'">
            <form :action="`/roasts/${selectedRoast}`" method="POST">
                @csrf
                @method('DELETE')

                <label class="block font-semibold mb-1">Select Roast</label>
                <select x-model="selectedRoast" class="border rounded p-2 w-full mb-4">
                    <option value="">-- Choose roast --</option>
                    @foreach($roasts as $roast)
                    <option value="{{ $roast->id }}">{{ $roast->roast }}</option>
                    @endforeach
                </select>

                <div class="flex gap-3">
                    <button type="submit" :disabled="!selectedRoast" class="bg-red-600 text-white px-4 py-2 rounded">Delete Roast</button>
                    <button type="button" @click="openRemoveDataModal = false" class="bg-gray-400 px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>

        {{-- TYPE DELETE --}}
        <div x-show="category === 'type'">
            <form :action="`/types/${selectedType}`" method="POST">
                @csrf
                @method('DELETE')

                <label class="block font-semibold mb-1">Select Type</label>
                <select x-model="selectedType" class="border rounded p-2 w-full mb-4">
                    <option value="">-- Choose type --</option>
                    @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->type }}</option>
                    @endforeach
                </select>

                <div class="flex gap-3">
                    <button type="submit" :disabled="!selectedType" class="bg-red-600 text-white px-4 py-2 rounded">Delete Type</button>
                    <button type="button" @click="openRemoveDataModal = false" class="bg-gray-400 px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>

    </div>
</div>