<div class="mb-4">
    <label for="{{ $name }}" class="block mb-1 font-medium">
        {{ $label }}
    </label>

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type ?? 'text' }}"
        value="{{ old($name) }}"
        {{ $attributes->merge([
            'class' => 'border border-gray-300 p-2 rounded w-full focus:ring focus:ring-blue-200'
        ]) }}
    />

    {{-- @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror --}}
</div>
