@props([
'countries',
'regions',
'hasDataErrors' => false,
])

<div
    x-cloak
    x-show="openAddDataModal"
    @click.self="openAddDataModal = false"
    class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded shadow-lg w-[80vw] max-h-[90vh] overflow-y-auto"
        x-data="{
            category: '{{ old('category', '') }}',
            regionCount: {{ old('regions') ? max(count(old('regions')), 4) : 4 }}
        }">

        <h2 class="text-xl font-bold mb-4">Add Data</h2>

        @if ($hasDataErrors)
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 border border-red-300">
            <strong>Validation Errors:</strong>
            <ul class="list-disc ml-5 mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <label class="block font-semibold mb-1">Select Category</label>
        <select x-model="category" class="border rounded p-2 w-full mb-4 @error('category') border-red-500 @enderror">
            <option value="">-- Choose category --</option>
            <option value="country">Country</option>
            <option value="roast">Roast</option>
            <option value="type">Type</option>
        </select>

        {{-- COUNTRY WITH REGIONS --}}
        <div x-show="category === 'country'">
            <form method="POST" action="{{ route('countries.store') }}">
                @csrf
                <input type="hidden" name="category" value="country">

                <label class="block font-semibold mb-1">Country Name <span class="text-red-600">*</span></label>
                <input
                    name="country"
                    placeholder="e.g., Finland"
                    value="{{ old('country') }}"
                    class="border rounded p-2 w-full mb-4 @error('country') border-red-500 @enderror">

                <label class="block font-semibold mb-1">Regions <span class="text-red-600">*</span></label>
                <p class="text-sm text-gray-600 mb-3">Add at least one region (fill in as many as you need)</p>

                <div class="space-y-3 mb-4">
                    @php
                    $oldRegions = (array) old('regions', ['']);
                    if (empty($oldRegions) || (count($oldRegions) === 1 && empty($oldRegions[0]))) {
                    $oldRegions = [''];
                    }
                    @endphp

                    <template x-for="(item, index) in regionCount" :key="index">
                        <input
                            type="text"
                            :name="'regions[' + index + ']'"
                            placeholder="e.g., Österbotten"
                            :value="(() => {
                                const oldData = {{ json_encode($oldRegions) }};
                                return oldData[index] !== undefined ? oldData[index] : '';
                            })()"
                            class="border rounded p-2 w-full @error('regions.*') border-red-500 @enderror">
                    </template>
                </div>

                <button
                    type="button"
                    @click="regionCount++"
                    class="bg-gray-500 text-white px-3 py-1 rounded text-sm mb-4">
                    + Add Another Region
                </button>

                <div class="flex gap-3">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded flex-1">
                        Save Country
                    </button>
                </div>
            </form>
        </div>

        {{-- ROAST --}}
        <div x-show="category === 'roast'">
            <form method="POST" action="{{ route('roasts.store') }}">
                @csrf
                <input type="hidden" name="category" value="roast">

                <label class="block font-semibold mb-1">Roast Name <span class="text-red-600">*</span></label>
                <input
                    name="roast"
                    placeholder="e.g., Light Roast"
                    value="{{ old('roast') }}"
                    class="border rounded p-2 w-full mb-3 @error('roast') border-red-500 @enderror">

                <div class="flex gap-3">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded flex-1">
                        Save Roast
                    </button>
                </div>
            </form>
        </div>

        {{-- TYPE --}}
        <div x-show="category === 'type'">
            <form method="POST" action="{{ route('types.store') }}">
                @csrf
                <input type="hidden" name="category" value="type">

                <label class="block font-semibold mb-1">Type Name <span class="text-red-600">*</span></label>
                <input
                    name="type"
                    placeholder="e.g., Arabica"
                    value="{{ old('type') }}"
                    class="border rounded p-2 w-full mb-3 @error('type') border-red-500 @enderror">

                <div class="flex gap-3">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded flex-1">
                        Save Type
                    </button>
                </div>
            </form>
        </div>

        <button
            @click="openAddDataModal = false"
            class="mt-4 bg-gray-400 text-white px-4 py-2 rounded w-full">
            Close
        </button>
    </div>
</div>