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

   {{-- ERROR MESSAGE (Global - error when Removing Data) --}}
   @if (session('error'))
   <div
      x-data="{ show: true }"
      x-show="show"
      x-transition
      class="mb-4 p-3 rounded bg-red-100 text-red-800 border border-red-300 max-w-7xl mx-auto">
      <div class="flex justify-between items-center">
         <span><strong>Error:</strong> {{ session('error') }}</span>
         <button @click="show = false" class="text-red-900 font-bold">×</button>
      </div>
   </div>
   @endif

   {{-- SHOW validation error for inline inventory update --}}
   @if ($errors->has('new_count'))
   <div class="mb-4 p-3 rounded bg-red-100 text-red-800 border border-red-300 max-w-7xl mx-auto">
      <div class="flex justify-between items-center">
         <span><strong>Error:</strong> {{ $errors->first('new_count') }}</span>
      </div>
   </div>
   @endif

   @php
   $productErrorFields = ['name', 'country_id', 'region_id', 'roast_id', 'type_id', 'price', 'inventory'];
   $dataErrorFields = ['country', 'regions', 'regions.*', 'region', 'roast', 'type', 'category'];

   $hasProductErrors = collect($productErrorFields)->some(fn($field) => $errors->has($field));
   $hasDataErrors = collect($dataErrorFields)->some(fn($field) => $errors->has($field));
   @endphp

   <div class="max-w-7xl mx-auto p-6">
      <div x-data="{
         openAddModal: {{ $hasProductErrors ? 'true' : 'false' }},
         openAddDataModal: {{ $hasDataErrors ? 'true' : 'false' }},
         openRemoveDataModal: false
      }">

         <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

         <button @click="openAddModal = true" class="bg-green-600 text-white px-4 py-2 rounded">
            Add Product
         </button>

         <button @click="openAddDataModal = true" class="bg-blue-600 text-white px-4 py-2 rounded ml-2">
            Add Data
         </button>

         <button @click="openRemoveDataModal = true" class="bg-red-600 text-white px-4 py-2 rounded ml-2">
            Remove Data
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
            },
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
                        <div class="font-semibold mb-2">Registered: {{ $product->inventory }}</div>

                        {{-- SET INVENTORY (reconciliation) --}}
                        <form method="POST" action="{{ route('admin.products.inventory.set', $product) }}" class="flex gap-2 items-center">
                           @csrf
                           @method('PUT')
                           <input type="number" min="0" name="new_count" placeholder="Actual" class="border rounded px-2 py-1 w-20" required>
                           <button class="bg-yellow-500 text-white px-3 py-1 rounded">Update</button>
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

         {{-- MODALS --}}
         <x-dashboard.modal-add-product
            :countries="$countries"
            :regions="$regions"
            :roasts="$roasts"
            :types="$types"
            :hasProductErrors="$hasProductErrors" />

         <x-dashboard.modal-add-data
            :countries="$countries"
            :regions="$regions"
            :hasDataErrors="$hasDataErrors" />

         <x-dashboard.modal-remove-data
            :countries="$countries"
            :regions="$regions"
            :roasts="$roasts"
            :types="$types" />

      </div>

      {{-- PAGINATION --}}
      <div class="mt-10 flex flex-col items-center gap-4">
         {{ $products->links() }}
      </div>
   </div>

   @vite('resources/js/addProduct.js')
</body>

</html>