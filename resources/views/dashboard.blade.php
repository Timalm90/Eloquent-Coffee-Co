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
      <div
         x-data="filterComponentDashboard({
                roast: '{{ request('roast') }}',
                type: '{{ request('type') }}',
                country: '{{ request('country') }}',
                in_stock: '{{ request('in_stock', '1') }}'
            })">

         <x-product.filters
            :filters="[
                    'roast' => request('roast'),
                    'type' => request('type'),
                    'country' => request('country'),
                    'in_stock' => request('in_stock', '1')
                ]"
            :roasts="$roasts"
            :types="$types"
            :countries="$countries"
            mode="dashboard"
         />

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
      <div class="mt-10 bg-white p-6 shadow rounded">
         <h2 class="text-xl font-bold mb-4">Add New Product</h2>

         <form method="POST" action="{{ route('dashboard.store') }}" class="grid grid-cols-3 gap-4">
            @csrf

            <input name="name" placeholder="Name" class="border rounded p-2">

            <select name="country_id" class="border rounded p-2">
               @foreach($countries as $country)
               <option value="{{ $country->id }}">{{ $country->country }}</option>
               @endforeach
            </select>

            <select name="region_id" class="border rounded p-2">
               @foreach($regions as $region)
               <option value="{{ $region->id }}">{{ $region->region }}</option>
               @endforeach
            </select>

            <select name="roast_id" class="border rounded p-2">
               @foreach($roasts as $roast)
               <option value="{{ $roast->id }}">{{ $roast->roast }}</option>
               @endforeach
            </select>

            <select name="type_id" class="border rounded p-2">
               @foreach($types as $type)
               <option value="{{ $type->id }}">{{ $type->type }}</option>
               @endforeach
            </select>

            <input name="price" type="number" step="0.01" placeholder="Price" class="border rounded p-2">
            <input name="inventory" type="number" placeholder="Inventory" class="border rounded p-2">

            <button class="bg-green-600 text-white px-4 py-2 rounded col-span-3">
               Add Product
            </button>
         </form>
      </div>

   </div>
</body>

</html>