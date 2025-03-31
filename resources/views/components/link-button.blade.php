@props(['href', 'color' => 'indigo'])

@php
    $colors = [
        'indigo' => 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500',
        'red' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
        'green' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
        // Add more colors as needed
    ];

    $colorClass = $colors[$color] ?? $colors['indigo'];
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 $colorClass"]) }}>
    {{ $slot }}
</a>
