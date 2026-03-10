@props([
'countries',
'regions',
'roasts',
'types',
'hasProductErrors' => false,
])

<div
    x-cloak
    x-show="openAddModal"
    @click.self="openAddModal = false"
    class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded shadow-lg w-[80vw] max-h-[90vh] overflow-y-auto">
        <h2 class="text-xl font-bold mb-4">Add Product</h2>

        @if ($hasProductErrors)
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 border border-red-300">
            <strong>Validation Errors:</strong>
            <ul class="list-disc ml-5 mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('dashboard.store') }}" class="grid grid-cols-3 gap-4">
            @csrf

            <input name="name" placeholder="Product Name" value="{{ old('name') }}"
                class="border rounded p-2 @error('name') border-red-500 @enderror">

            <select name="country_id" id="countrySelect"
                class="border rounded p-2 @error('country_id') border-red-500 @enderror">
                <option value="">-- Select country --</option>
                @foreach($countries as $country)
                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                    {{ $country->country }}
                </option>
                @endforeach
            </select>

            <select name="region_id" id="regionSelect"
                class="border rounded p-2 @error('region_id') border-red-500 @enderror">
                <option value="">-- Select region --</option>
                @if(old('country_id'))
                @foreach($regions->where('country_id', old('country_id')) as $region)
                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                    {{ $region->region }}
                </option>
                @endforeach
                @endif
            </select>

            <select name="roast_id" class="border rounded p-2 @error('roast_id') border-red-500 @enderror">
                <option value="">-- Choose roast --</option>
                @foreach($roasts as $roast)
                <option value="{{ $roast->id }}" {{ old('roast_id') == $roast->id ? 'selected' : '' }}>
                    {{ $roast->roast }}
                </option>
                @endforeach
            </select>

            <select name="type_id" class="border rounded p-2 @error('type_id') border-red-500 @enderror">
                <option value="">-- Choose type --</option>
                @foreach($types as $type)
                <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                    {{ $type->type }}
                </option>
                @endforeach
            </select>

            <input name="price" type="number" step="0.01" value="{{ old('price') }}" placeholder="Price"
                class="border rounded p-2 @error('price') border-red-500 @enderror">

            <input name="inventory" type="number" value="{{ old('inventory') }}" placeholder="Inventory"
                class="border rounded p-2 @error('inventory') border-red-500 @enderror">

            <div class="col-span-3 flex gap-3">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded flex-1">Add Product</button>
                <button type="button" @click="openAddModal = false" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
            </div>
        </form>
    </div>
</div>