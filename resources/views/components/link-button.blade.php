@props([
    'href' => '#',
    'type' => 'default', // Может быть 'login', 'register', 'default'
    'target' => null,
])

<a href="{{ $href }}" {{ $target ? 'target="' . $target . '"' : '' }}
    class="inline-flex items-center px-4 py-2 border rounded-md font-medium text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150">
    {{ $slot }}
</a>
