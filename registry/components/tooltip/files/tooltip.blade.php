@props([
    'text' => '',
    'side' => 'top',
])

@php
    $position = match ($side) {
        'bottom' => 'top-full mt-2 left-1/2 -translate-x-1/2',
        'left' => 'right-full mr-2 top-1/2 -translate-y-1/2',
        'right' => 'left-full ml-2 top-1/2 -translate-y-1/2',
        default => 'bottom-full mb-2 left-1/2 -translate-x-1/2',
    };

    $tipClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'absolute z-50 w-max max-w-xs rounded-md bg-primary px-3 py-1.5 text-xs text-primary-foreground shadow-md',
        $position,
        $attributes->get('class'),
    );
@endphp

<span class="relative inline-flex" x-data="{ show: false }"
    @mouseenter="show = true" @mouseleave="show = false" @focusin="show = true"
    @focusout="show = false">
    {{ $slot }}

    <span x-show="show" x-cloak x-transition role="tooltip"
        class="{{ $tipClasses }}">
        {{ $text }}
    </span>
</span>
