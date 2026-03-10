<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Admin - Eloquent Coffee Co</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
   <x-header />

   <main id="main-content">

      {{-- SUCCESS MESSAGE --}}
      @if (session('success'))
      <div
         x-data="{ show: true }"
         x-show="show"
         x-transition
         role="status"
         aria-live="polite"
         class="p-4 rounded-lg bg-green-50 text-green-800 border border-green-200 max-w-7xl mx-auto mt-6 px-6">
         <div class="flex justify-between items-center">
            <span class="text-sm font-medium"><strong>Success:</strong> {{ session('success') }}</span>
            <button @click="show = false" class="text-green-700 hover:text-green-900 font-bold ml-4" aria-label="Dismiss success message">×</button>
         </div>
      </div>
      @endif

      {{-- ERROR MESSAGE --}}
      @if (session('error'))
      <div
         x-data="{ show: true }"
         x-show="show"
         x-transition
         role="alert"
         aria-live="assertive"
         class="p-4 rounded-lg bg-red-50 text-red-800 border border-red-200 max-w-7xl mx-auto mt-6 px-6">
         <div class="flex justify-between items-center">
            <span class="text-sm font-medium"><strong>Error:</strong> {{ session('error') }}</span>
            <button @click="show = false" class="text-red-700 hover:text-red-900 font-bold ml-4" aria-label="Dismiss error message">×</button>
         </div>
      </div>
      @endif

      {{-- INVENTORY VALIDATION ERROR --}}
      @if ($errors->has('new_count'))
      <div
         role="alert"
         class="p-4 rounded-lg bg-red-50 text-red-800 border border-red-200 max-w-7xl mx-auto mt-6 px-6">
         <span class="text-sm font-medium"><strong>Error:</strong> {{ $errors->first('new_count') }}</span>
      </div>
      @endif

      @php
      $productErrorFields = ['name', 'country_id', 'region_id', 'roast_id', 'type_id', 'price', 'inventory'];
      $dataErrorFields = ['country', 'regions', 'regions.*', 'region', 'roast', 'type', 'category'];

      $hasProductErrors = collect($productErrorFields)->some(fn($field) => $errors->has($field));
      $hasDataErrors = collect($dataErrorFields)->some(fn($field) => $errors->has($field));
      @endphp

      <div class="max-w-7xl mx-auto px-6 py-12">
         <div x-data="{
            openAddModal: {{ $hasProductErrors ? 'true' : 'false' }},
            openAddDataModal: {{ $hasDataErrors ? 'true' : 'false' }},
            openRemoveDataModal: false
         }">

            {{-- PAGE HEADER --}}
            <div class="mb-10">
               <h1 class="text-4xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
               <p class="text-gray-600">Manage products, inventory, and catalogue data</p>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex gap-3 mb-8" role="toolbar" aria-label="Dashboard actions">
               <button
                  @click="openAddModal = true"
                  aria-haspopup="dialog"
                  aria-controls="modal-add-product"
                  class="px-5 py-2.5 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                  + Add Product
               </button>
               <button
                  @click="openAddDataModal = true"
                  aria-haspopup="dialog"
                  aria-controls="modal-add-data"
                  class="px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors duration-200">
                  Add Data
               </button>
               <button
                  @click="openRemoveDataModal = true"
                  aria-haspopup="dialog"
                  aria-controls="modal-remove-data"
                  class="px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors duration-200">
                  Remove Data
               </button>
            </div>

            {{-- SEARCH --}}
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
               <form method="GET" role="search" aria-label="Search products">
                  <div class="flex gap-3 items-center">
                     <div class="flex-1">
                        <label for="dashboard-search" class="sr-only">Search products</label>
                        <input
                           id="dashboard-search"
                           type="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search products..."
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent" />
                     </div>
                     <button
                        type="submit"
                        class="px-6 py-3 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        Search
                     </button>
                  </div>
               </form>
            </div>

            {{-- FILTERS --}}
            <div class="mb-8">
               <div x-data="filterComponentDashboard({
                  roast: '{{ request('roast') }}',
                  type: '{{ request('type') }}',
                  country: '{{ request('country') }}',
                  region: '{{ request('region') }}'
               })">
                  <x-product.filters
                     :filters="[
                        'roast' => request('roast'),
                        'type' => request('type'),
                        'country' => request('country'),
                        'region' => request('region')
                     ]"
                     :roasts="$roasts"
                     :types="$types"
                     :countries="$countries"
                     :regions="$regions"
                     mode="dashboard" />
               </div>
            </div>

            {{-- INVENTORY TABLE --}}
            <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
               <table class="min-w-full text-sm text-left" aria-label="Product inventory">
                  <thead>
                     <tr class="border-b border-gray-200">
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Name</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Country</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Region</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Roast</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Type</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Price</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Inventory</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                     </tr>
                  </thead>

                  <tbody class="divide-y divide-gray-100">
                     @foreach($products as $product)
                     <tr x-data="{ confirmDelete: false }" class="hover:bg-gray-50 transition-colors duration-100">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $product->origin->country }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $product->region->region }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $product->roast->roast }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $product->type->type }}</td>

                        {{-- PRICE --}}
                        <td class="px-4 py-3">
                           <form method="POST" action="{{ route('dashboard.updatePrice', $product) }}" class="flex gap-2 items-center" aria-label="Update price for {{ $product->name }}">
                              @csrf
                              @method('PUT')
                              <label for="price-{{ $product->id }}" class="sr-only">Price for {{ $product->name }}</label>
                              <input
                                 id="price-{{ $product->id }}"
                                 type="number" step="0.01" name="price" value="{{ $product->price }}"
                                 class="border border-gray-300 rounded-lg px-2 py-1.5 w-24 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                              <button class="px-3 py-1.5 bg-gray-800 hover:bg-gray-900 text-white text-xs font-medium rounded-lg transition-colors duration-200">Save</button>
                           </form>
                        </td>

                        {{-- INVENTORY --}}
                        <td class="px-4 py-3">
                           <div class="text-xs text-gray-500 mb-2">Registered: <span class="font-semibold text-gray-700">{{ $product->inventory }}</span></div>
                           <form method="POST" action="{{ route('admin.products.inventory.set', $product) }}" class="flex gap-2 items-center" aria-label="Set inventory for {{ $product->name }}">
                              @csrf
                              @method('PUT')
                              <label for="inventory-{{ $product->id }}" class="sr-only">Actual inventory count for {{ $product->name }}</label>
                              <input
                                 id="inventory-{{ $product->id }}"
                                 type="number" min="0" name="new_count" placeholder="Actual"
                                 class="border border-gray-300 rounded-lg px-2 py-1.5 w-20 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                              <button class="px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 text-xs font-medium rounded-lg border border-gray-300 transition-colors duration-200">Set</button>
                           </form>
                        </td>

                        {{-- ACTIONS --}}
                        <td class="px-4 py-3">
                           <form method="POST" action="{{ route('dashboard.addInventory', $product) }}" class="flex gap-2 items-center mb-2" aria-label="Add inventory for {{ $product->name }}">
                              @csrf
                              <label for="incoming-{{ $product->id }}" class="sr-only">Incoming quantity for {{ $product->name }}</label>
                              <input
                                 id="incoming-{{ $product->id }}"
                                 type="number" name="incoming" placeholder="Qty"
                                 class="border border-gray-300 rounded-lg px-2 py-1.5 w-14 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                              <button class="px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 text-xs font-medium rounded-lg border border-gray-300 transition-colors duration-200">Add</button>
                           </form>

                           <button
                              @click="confirmDelete = true"
                              aria-haspopup="dialog"
                              :aria-expanded="confirmDelete.toString()"
                              class="px-3 py-1.5 bg-white hover:bg-red-50 text-red-600 text-xs font-medium rounded-lg border border-red-200 hover:border-red-300 transition-colors duration-200">
                              Delete
                           </button>

                           {{-- DELETE CONFIRM DIALOG --}}
                           <div
                              x-cloak
                              x-show="confirmDelete"
                              role="dialog"
                              aria-modal="true"
                              aria-labelledby="delete-title-{{ $product->id }}"
                              aria-describedby="delete-desc-{{ $product->id }}"
                              class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50">
                              <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full mx-4">
                                 <h3 id="delete-title-{{ $product->id }}" class="font-semibold text-gray-900 mb-1">Delete product?</h3>
                                 <p id="delete-desc-{{ $product->id }}" class="text-sm text-gray-500 mb-6">This action cannot be undone.</p>
                                 <div class="flex gap-3">
                                    <form method="POST" action="{{ route('dashboard.destroy', $product) }}">
                                       @csrf
                                       @method('DELETE')
                                       <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">Delete</button>
                                    </form>
                                    <button type="button" @click="confirmDelete = false" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-300 transition-colors duration-200">Cancel</button>
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
         <nav aria-label="Product pagination" class="mt-10 flex flex-col items-center gap-4">
            {{ $products->links() }}
         </nav>
      </div>

   </main>

   @vite('resources/js/addProduct.js')
</body>

</html>