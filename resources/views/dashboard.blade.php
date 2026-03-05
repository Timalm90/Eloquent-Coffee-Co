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

   <div class="max-w-7xl mx-auto p-6">

      <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

      {{-- FILTER --}}
      {{-- Search function --}}
      <form method="GET" class="mb-6 flex gap-3 items-center">
   <input
      type="text"
      name="search"
      value="{{ request('search') }}"
      placeholder="Type here to search..."
      class="border rounded px-3 py-2 w-64"
   />

   <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">
      Search
   </button>
</form>

      <div x-data="filterComponentDashboard({
         roast: '{{ request('roast') }}',
         type: '{{ request('type') }}',
         country: '{{ request('country') }}',
         in_stock: '{{ request('in_stock', '1') }}'
         })">
                
         <x-product.filters :filters="[
            'roast' => request('roast'),
            'type' => request('type'),
            'country' => request('country'),
            'in_stock' => request('in_stock', '1')
            ]"
            :roasts="$roasts"
            :types="$types"
            :countries="$countries"
            mode="dashboard" />
            
      </div>

      {{-- INVENTORY GRID --}}
      <div class="bg-white shadow rounded overflow-x-auto">

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

                  {{-- PRICE-FORM --}}
                  <td class="p-3">
                     <form method="POST" action="{{ route('dashboard.updatePrice', $product) }}" class="flex gap-2">
                        @csrf
                        @method('PUT')

                        <input type="number"
                               step="0.01"
                               name="price"
                               value="{{ $product->price }}"
                               class="border rounded px-2 py-1 w-24">

                        <button class="bg-blue-500 text-white px-3 py-1 rounded">
                           Save
                        </button>
                     </form>
                  </td>

                                    {{-- INVENTORY READ-ONLY --}}
                  <td class="p-3 font-semibold">
                     {{ $product->inventory }}
                  </td>

                                    {{-- INCOMING STOCK --}}
                  <td class="p-3">
                     <form method="POST" action="{{ route('dashboard.addInventory', $product) }}" class="flex gap-2">
                        @csrf

                        <input type="number"
                               name="incoming"
                               placeholder="0"
                               class="border rounded px-2 py-1 w-20">

                        <button class="bg-green-600 text-white px-3 py-1 rounded">
                           Add
                        </button>
                     </form>

                     <button @click="confirmDelete = true"
                             class="bg-red-500 text-white px-3 py-1 rounded">
                        Delete
                     </button>

                     <div x-cloak x-show="confirmDelete"
                        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                        <div class="bg-white p-6 rounded shadow">
                           <p>You are about to delete this product. Confirm?</p>
                           <div class="flex gap-3 mt-4">

                              <form method="POST" action="{{ route('dashboard.destroy', $product) }}">
                                 @csrf
                                 @method('DELETE')
                                 <button class="bg-red-600 text-white px-4 py-2 rounded">
                                    Delete
                                 </button>
                              </form>

                              <button type="button"
                                 @click="confirmDelete = false"
                                 class="bg-gray-400 px-4 py-2 rounded">
                                 Cancel
                              </button>

                           </div>
                        </div>
                     </div>
                  </td>

               </tr>
               @endforeach
            </tbody>
         </table>
      </div>

      {{-- ADD NEW PRODUCT --}}
      <form method="POST" action="{{ route('dashboard.store') }}" class="grid grid-cols-3 gap-4">
      @csrf

    <input name="name" placeholder="Name" class="border rounded p-2">

    {{-- COUNTRY --}}
      <select name="country_id" id="countrySelect" class="border rounded p-2">
         <option value="">-- Select country --</option>
         @foreach($countries as $country)
            <option value="{{ $country->id }}">{{ $country->country }}</option>
         @endforeach
      </select>

    {{-- REGION --}}
      <select name="region_id" id="regionSelect" class="border rounded p-2" disabled>
         <option value="">-- Select country first --</option>
      </select>

    {{-- ROAST --}}
      <select name="roast_id" class="border rounded p-2">
         <option value="">-- Choose roast --</option>
         @foreach($roasts as $roast)
            <option value="{{ $roast->id }}">{{ $roast->roast }}</option>
         @endforeach
      </select>

    {{-- TYPE --}}
      <select name="type_id" class="border rounded p-2">
         <option value="">-- Choose type --</option>
         @foreach($types as $type)
            <option value="{{ $type->id }}">{{ $type->type }}</option>
         @endforeach
      </select>

      <input name="price" type="number" step="0.01" placeholder="0" class="border rounded p-2">
      <input name="inventory" type="number" placeholder="0" class="border rounded p-2">

      <button class="bg-green-600 text-white px-4 py-2 rounded col-span-3">
         Add Product
      </button>
   </form>

   </div>

   @vite('resources/js/addProduct.js')

</body>

</html>