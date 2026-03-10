<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Admin - Eloquent Coffee Co</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
   <x-header />

   {{-- SUCCESS MESSAGE (Global only) --}}
   @if (session('success'))
   <div
      x-data="{ show: true }"
      x-show="show"
      x-transition
      class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300 max-w-7xl mx-auto">
      <div class="flex justify-between items-center">
         <span><strong>Success!</strong> {{ session('success') }}</span>
         <button @click="show = false" class="text-green-900 font-bold">×</button>
      </div>
   </div>
   @endif

   @php
   // Define which errors belong to which modal
   $productErrorFields = ['name', 'country_id', 'region_id', 'roast_id', 'type_id', 'price', 'inventory'];
   $dataErrorFields = ['country', 'regions', 'regions.*', 'region', 'roast', 'type', 'category'];

   // Check if we have errors for each modal
   $hasProductErrors = collect($productErrorFields)->some(fn($field) => $errors->has($field));
   $hasDataErrors = collect($dataErrorFields)->some(fn($field) => $errors->has($field));
   @endphp

   <div class="max-w-7xl mx-auto p-6">
      <div x-data="{ 
         openAddModal: {{ $hasProductErrors ? 'true' : 'false' }},
         openAddDataModal: {{ $hasDataErrors ? 'true' : 'false' }}
      }">

         <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

         <button @click="openAddModal = true" class="bg-green-600 text-white px-4 py-2 rounded">
            Add Product
         </button>

         <button @click="openAddDataModal = true" class="bg-blue-600 text-white px-4 py-2 rounded ml-2">
            Add Data
         </button>

         {{-- SEARCH FORM --}}
         <form method="GET" class="mb-6 flex gap-3 items-center mt-4">
            <input
               type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Type here to search..."
               class="border rounded px-3 py-2 w-64" />

            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">
               Search
            </button>
         </form>

         {{-- FILTER --}}
         <div x-data="filterComponentDashboard({

         get hasFilters() {
    return (
        this.filters.roast ||
        this.filters.type ||
        this.filters.country
    );
}
            roast: '{{ request('roast') }}',
            type: '{{ request('type') }}',
            country: '{{ request('country') }}'
         })">

            <x-product.filters
               :filters="[
                  'roast' => request('roast'),
                  'type' => request('type'),
                  'country' => request('country')
               ]"
               :roasts="$roasts"
               :types="$types"
               :countries="$countries"
               mode="dashboard" />
         </div>

         {{-- INVENTORY TABLE --}}
         <div class="bg-white shadow rounded overflow-x-auto mt-6">
            <table class="min-w-full text-sm text-left">
               <thead class="bg-gray-100">
                  <tr>
                     <th class="p-3">Name</th>
                     <th class="p-3">Country</th>
                     <th class="p-3">Region</th>
                     <th class="p-3">Roast</th>
                     <th class="p-3">Type</th>
                     <th class="p-3">Price</th>
                     <th class="p-3">Inventory</th>
                     <th class="p-3">Actions</th>
                  </tr>
               </thead>

               <tbody>
                  @foreach($products as $product)
                  <tr x-data="{ confirmDelete: false }" class="border-t">
                     <td class="p-3">{{ $product->name }}</td>
                     <td class="p-3">{{ $product->origin->country }}</td>
                     <td class="p-3">{{ $product->region->region }}</td>
                     <td class="p-3">{{ $product->roast->roast }}</td>
                     <td class="p-3">{{ $product->type->type }}</td>

                     {{-- PRICE FORM --}}
                     <td class="p-3">
                        <form method="POST" action="{{ route('dashboard.updatePrice', $product) }}" class="flex gap-2">
                           @csrf
                           @method('PUT')
                           <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="border rounded px-2 py-1 w-24">
                           <button class="bg-blue-500 text-white px-3 py-1 rounded">Save</button>
                        </form>
                     </td>

                     {{-- INVENTORY --}}
                     <td class="p-3">
                        <div class="font-semibold mb-2">Current: {{ $product->inventory }}</div>

                        {{-- SET INVENTORY (reconciliation) --}}
                        <form method="POST" action="{{ route('admin.products.inventory.set', $product) }}" class="flex gap-2 items-center">
                           @csrf
                           @method('PUT')
                           <input type="number" name="new_count" placeholder="New" class="border rounded px-2 py-1 w-20" required>
                           <button class="bg-yellow-500 text-white px-3 py-1 rounded">Set</button>
                        </form>
                     </td>

                     {{-- ACTIONS --}}
                     <td class="p-3">
                        <form method="POST" action="{{ route('dashboard.addInventory', $product) }}" class="flex gap-2 mb-2">
                           @csrf
                           <input type="number" name="incoming" placeholder="0" class="border rounded px-2 py-1 w-20">
                           <button class="bg-green-600 text-white px-3 py-1 rounded">Add</button>
                        </form>

                        <button @click="confirmDelete = true" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>

                        {{-- DELETE MODAL --}}
                        <div x-cloak x-show="confirmDelete" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                           <div class="bg-white p-6 rounded shadow">
                              <p>You are about to delete this product. Confirm?</p>
                              <div class="flex gap-3 mt-4">
                                 <form method="POST" action="{{ route('dashboard.destroy', $product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                                 </form>
                                 <button type="button" @click="confirmDelete = false" class="bg-gray-400 px-4 py-2 rounded">Cancel</button>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>

         {{-- ========================================== --}}
         {{-- ADD PRODUCT MODAL --}}
         {{-- ========================================== --}}
         <div
            x-cloak
            x-show="openAddModal"
            @click.self="openAddModal = false"
            class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50">

            <div class="bg-white p-6 rounded shadow-lg w-[80vw] max-h-[90vh] overflow-y-auto">
               <h2 class="text-xl font-bold mb-4">Add Product</h2>

               {{-- PRODUCT ERRORS --}}
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

         {{-- ========================================== --}}
         {{-- ADD DATA MODAL --}}
         {{-- ========================================== --}}
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

               {{-- DATA ERRORS --}}
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
                  <option value="region">Region</option>
                  <option value="roast">Roast</option>
                  <option value="type">Type</option>
               </select>

               {{-- ========================================== --}}
               {{-- COUNTRY WITH REGIONS --}}
               {{-- ========================================== --}}
               <div x-show="category === 'country'">
                  <form method="POST" action="{{ route('countries.store') }}">
                     @csrf

                     {{-- Hidden field to preserve category selection --}}
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
                        // If old regions exist but are empty, still show at least one field
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

               {{-- ========================================== --}}
               {{-- REGION ONLY --}}
               {{-- ========================================== --}}
               <div x-show="category === 'region'">
                  <form method="POST" action="{{ route('regions.store') }}">
                     @csrf

                     {{-- Hidden field to preserve category selection --}}
                     <input type="hidden" name="category" value="region">

                     <label class="block font-semibold mb-1">Country <span class="text-red-600">*</span></label>
                     <select
                        name="country_id"
                        class="border rounded p-2 w-full mb-3 @error('country_id') border-red-500 @enderror">
                        <option value="">-- Select country --</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                           {{ $country->country }}
                        </option>
                        @endforeach
                     </select>

                     <label class="block font-semibold mb-1">Region Name <span class="text-red-600">*</span></label>
                     <input
                        name="region"
                        placeholder="e.g., Österbotten"
                        value="{{ old('region') }}"
                        class="border rounded p-2 w-full mb-3 @error('region') border-red-500 @enderror">

                     <div class="flex gap-3">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded flex-1">
                           Save Region
                        </button>
                     </div>
                  </form>
               </div>

               {{-- ========================================== --}}
               {{-- ROAST --}}
               {{-- ========================================== --}}
               <div x-show="category === 'roast'">
                  <form method="POST" action="{{ route('roasts.store') }}">
                     @csrf

                     {{-- Hidden field to preserve category selection --}}
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

               {{-- ========================================== --}}
               {{-- TYPE --}}
               {{-- ========================================== --}}
               <div x-show="category === 'type'">
                  <form method="POST" action="{{ route('types.store') }}">
                     @csrf

                     {{-- Hidden field to preserve category selection --}}
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

      </div>

      {{-- PAGINATION --}}
      <div class="mt-6">
         {{ $products->links() }}
      </div>
   </div>

   @vite('resources/js/addProduct.js')
</body>

</html>