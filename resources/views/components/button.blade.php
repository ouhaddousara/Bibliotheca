@props([
    'type' => 'button',
    'href' => null,
    'target' => '_self',
    'primary' => false,
    'secondary' => false,
    'success' => false,
    'danger' => false,
    'warning' => false,
    'info' => false,
    'outline' => false,
    'sm' => false,
    'lg' => false,
    'fullWidth' => false,
    'disabled' => false,
])

@php
    // Déterminer la couleur de base
    $color = 'gray';
    if ($primary) $color = 'indigo';
    elseif ($secondary) $color = 'gray';
    elseif ($success) $color = 'green';
    elseif ($danger) $color = 'red';
    elseif ($warning) $color = 'yellow';
    elseif ($info) $color = 'blue';

    // Classes de base
    $classes = [
        'inline-flex items-center justify-center font-medium rounded-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2',
        $fullWidth ? 'w-full' : '',
        $sm ? 'px-3 py-1.5 text-sm' : ($lg ? 'px-6 py-3 text-lg' : 'px-4 py-2 text-base'),
    ];

    // Classes de couleur
    if ($outline) {
        $classes[] = "border-2 text-{$color}-600 border-{$color}-600 hover:bg-{$color}-50 focus:ring-{$color}-500";
    } else {
        $classes[] = "text-white bg-{$color}-600 hover:bg-{$color}-700 focus:ring-{$color}-500";
    }

    // Classes disabled
    if ($disabled) {
        $classes[] = 'opacity-50 cursor-not-allowed';
    }
@endphp

@if ($href)
    <a 
        href="{{ $href }}" 
        target="{{ $target }}"
        {{ $attributes->merge(['class' => implode(' ', array_filter($classes))]) }}
        @if($disabled) aria-disabled="true" tabindex="-1" @endif
    >
        {{ $slot }}
    </a>
@else
    <button 
        type="{{ $type }}" 
        {{ $attributes->merge(['class' => implode(' ', array_filter($classes))]) }}
        @if($disabled) disabled @endif
    >
        {{ $slot }}
    </button>
@endif