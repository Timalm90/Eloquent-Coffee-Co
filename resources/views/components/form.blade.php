<form method="{{ $method ?? 'POST' }}" action="{{ $action }}" {{ $attributes }} class="max-w-sm">
    @csrf
    {{ $slot }}
</form>
