@props([
'countries',
'regions',
'hasDataErrors' => false,
])

<div
    id="modal-add-data"
    x-cloak
    x-show="openAddDataModal"
    @click.self="openAddDataModal = false"
    @keydown.escape.window="openAddDataModal = false"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-add-data-title"
    class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-lg shadow-lg w-[80vw] max-h-[90vh] overflow-y-auto"
        x-data="{
            category: '{{ old('category', '') }}',
            regionCount: {{ old('regions') ? max(count(old('regions')), 4) : 4 }}
        }">

        <h2 id="modal-add-data-title" class="text-xl font-semibold text-gray-900 mb-1">Add Data</h2>
        <p class="text-sm text-gray-500 mb-6">Add new countries, roasts, or types to the catalogue</p>

        @if ($hasDataErrors)
        <div role="alert" class="mb-6 p-4 rounded-lg bg-red-50 text-red-800 border border-red-200">
            <p class="text-sm font-semibold mb-2">Please fix the following errors:</p>
            <ul class="list-disc ml-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex flex-col gap-1 mb-6">
            <label for="data-category" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Category</label>
            <select
                id="data-category"
                x-model="category"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('category') border-red-400 @enderror"
                aria-controls="section-country section-roast section-type">
                <option value="">-- Choose category --</option>
                <option value="country">Country</option>
                <option value="roast">Roast</option>
                <option value="type">Type</option>
            </select>
        </div>

        {{-- COUNTRY WITH REGIONS --}}
        <section id="section-country" x-show="category === 'country'" aria-label="Add country">
            <form method="POST" action="{{ route('countries.store') }}" novalidate>
                @csrf
                <input type="hidden" name="category" value="country">

                <div class="flex flex-col gap-1 mb-4">
                    <label for="country-name" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Country Name
                        <span aria-hidden="true" class="text-red-500">*</span>
                        <span class="sr-only">(required)</span>
                    </label>
                    <input
                        id="country-name"
                        name="country"
                        placeholder="e.g., Finland"
                        value="{{ old('country') }}"
                        required
                        aria-required="true"
                        @error('country') aria-invalid="true" aria-describedby="error-country-name" @enderror
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('country') border-red-400 @enderror">
                    @error('country')
                    <p id="error-country-name" role="alert" class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <fieldset class="mb-4">
                    <legend class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">
                        Regions
                        <span aria-hidden="true" class="text-red-500">*</span>
                        <span class="sr-only">(at least one required)</span>
                    </legend>
                    <p class="text-xs text-gray-400 mb-3">Add at least one region — fill in as many as you need</p>

                    <div class="space-y-2 mb-4">
                        @php
                        $oldRegions = (array) old('regions', ['']);
                        if (empty($oldRegions) || (count($oldRegions) === 1 && empty($oldRegions[0]))) {
                        $oldRegions = [''];
                        }
                        @endphp

                        <template x-for="(item, index) in regionCount" :key="index">
                            <div>
                                <label :for="'region-' + index" class="sr-only" x-text="'Region ' + (index + 1)"></label>
                                <input
                                    :id="'region-' + index"
                                    type="text"
                                    :name="'regions[' + index + ']'"
                                    placeholder="e.g., Österbotten"
                                    :value="(() => {
                                        const oldData = {{ json_encode($oldRegions) }};
                                        return oldData[index] !== undefined ? oldData[index] : '';
                                    })()"
                                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-gray-400 @error('regions.*') border-red-400 @enderror">
                            </div>
                        </template>
                    </div>

                    <button
                        type="button"
                        @click="regionCount++"
                        class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors duration-200 mb-6">
                        + Add Another Region
                    </button>
                </fieldset>

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
        </section>

        {{-- ROAST --}}
        <section id="section-roast" x-show="category === 'roast'" aria-label="Add roast">
            <form method="POST" action="{{ route('roasts.store') }}" novalidate>
                @csrf
                <input type="hidden" name="category" value="roast">

                <div class="flex flex-col gap-1 mb-6">
                    <label for="roast-name" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Roast Name
                        <span aria-hidden="true" class="text-red-500">*</span>
                        <span class="sr-only">(required)</span>
                    </label>
                    <input
                        id="roast-name"
                        name="roast"
                        placeholder="e.g., Light Roast"
                        value="{{ old('roast') }}"
                        required
                        aria-required="true"
                        @error('roast') aria-invalid="true" aria-describedby="error-roast-name" @enderror
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('roast') border-red-400 @enderror">
                    @error('roast')
                    <p id="error-roast-name" role="alert" class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
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
        </section>

        {{-- TYPE --}}
        <section id="section-type" x-show="category === 'type'" aria-label="Add type">
            <form method="POST" action="{{ route('types.store') }}" novalidate>
                @csrf
                <input type="hidden" name="category" value="type">

                <div class="flex flex-col gap-1 mb-6">
                    <label for="type-name" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Type Name
                        <span aria-hidden="true" class="text-red-500">*</span>
                        <span class="sr-only">(required)</span>
                    </label>
                    <input
                        id="type-name"
                        name="type"
                        placeholder="e.g., Arabica"
                        value="{{ old('type') }}"
                        required
                        aria-required="true"
                        @error('type') aria-invalid="true" aria-describedby="error-type-name" @enderror
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 @error('type') border-red-400 @enderror">
                    @error('type')
                    <p id="error-type-name" role="alert" class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
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
        </section>

        {{-- Placeholder when no category selected --}}
        <div x-show="category === ''" class="py-8 text-center text-sm text-gray-400" aria-live="polite">
            Select a category above to get started
        </div>

    </div>
</div>