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

    <div class="bg-white p-6 rounded-lg shadow-lg w-[80vw] max-h-[90vh] overflow-y-auto"
        x-data="{
            category: '{{ old('category', '') }}',
            regionCount: {{ old('regions') ? max(count(old('regions')), 4) : 4 }}
        }">

        <h2 class="text-xl font-semibold text-gray-900 mb-1">Add Data</h2>
        <p class="text-sm text-gray-500 mb-6">Add new countries, roasts, or types to the catalogue</p>

        @if ($hasDataErrors)
        <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-800 border border-red-200">
            <p class="text-sm font-semibold mb-2">Please fix the following errors:</p>
            <ul class="list-disc ml-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex flex-col gap-1 mb-6">
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Category</label>
            <select x-model="category" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('category') border-red-400 @enderror">
                <option value="">-- Choose category --</option>
                <option value="country">Country</option>
                <option value="roast">Roast</option>
                <option value="type">Type</option>
            </select>
        </div>

        {{-- COUNTRY WITH REGIONS --}}
        <div x-show="category === 'country'">
            <form method="POST" action="{{ route('countries.store') }}">
                @csrf
                <input type="hidden" name="category" value="country">

                <div class="flex flex-col gap-1 mb-4">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Country Name <span class="text-red-500">*</span></label>
                    <input
                        name="country"
                        placeholder="e.g., Finland"
                        value="{{ old('country') }}"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('country') border-red-400 @enderror">
                </div>

                <div class="flex flex-col gap-1 mb-3">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Regions <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-400">Add at least one region — fill in as many as you need</p>
                </div>

                <div class="space-y-2 mb-4">
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
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-gray-400 @error('regions.*') border-red-400 @enderror">
                    </template>
                </div>

                <button
                    type="button"
                    @click="regionCount++"
                    class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors duration-200 mb-6">
                    + Add Another Region
                </button>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        Save Country
                    </button>
                    <button type="button" @click="openAddDataModal = false"
                        class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        {{-- ROAST --}}
        <div x-show="category === 'roast'">
            <form method="POST" action="{{ route('roasts.store') }}">
                @csrf
                <input type="hidden" name="category" value="roast">

                <div class="flex flex-col gap-1 mb-6">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Roast Name <span class="text-red-500">*</span></label>
                    <input
                        name="roast"
                        placeholder="e.g., Light Roast"
                        value="{{ old('roast') }}"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('roast') border-red-400 @enderror">
                </div>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        Save Roast
                    </button>
                    <button type="button" @click="openAddDataModal = false"
                        class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        {{-- TYPE --}}
        <div x-show="category === 'type'">
            <form method="POST" action="{{ route('types.store') }}">
                @csrf
                <input type="hidden" name="category" value="type">

                <div class="flex flex-col gap-1 mb-6">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Type Name <span class="text-red-500">*</span></label>
                    <input
                        name="type"
                        placeholder="e.g., Arabica"
                        value="{{ old('type') }}"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('type') border-red-400 @enderror">
                </div>

                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        Save Type
                    </button>
                    <button type="button" @click="openAddDataModal = false"
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