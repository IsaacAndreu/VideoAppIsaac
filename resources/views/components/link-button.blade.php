@props([
    'href',
    'color' => 'blue', // 'blue', 'green', 'red', 'gray'...
])

@php
    $baseClasses = 'inline-block px-4 py-2 rounded font-semibold transition text-white';
    $colorClasses = match ($color) {
        'green' => 'bg-green-600 hover:bg-green-700',
        'red' => 'bg-red-600 hover:bg-red-700',
        'gray' => 'bg-gray-600 hover:bg-gray-700',
        default => 'bg-blue-600 hover:bg-blue-700',
    };
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "$baseClasses $colorClasses"]) }}>
    {{ $slot }}
</a>
