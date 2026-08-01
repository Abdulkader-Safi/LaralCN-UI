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

    // Shown while the wrapper is hovered or anything inside it holds focus, so
    // pointer and keyboard both work. No JavaScript needed.
    $tipClasses = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'pointer-events-none invisible absolute z-50 w-fit max-w-xs text-balance rounded-md bg-primary px-3 py-1.5 text-xs text-primary-foreground opacity-0 transition-opacity duration-150 group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100',
        $position,
        $attributes->get('class'),
    );
@endphp

<span class="group relative inline-flex" {{ $attributes->except('class') }}>
    {{ $slot }}

    <span role="tooltip" class="{{ $tipClasses }}">
        {{ $text }}
    </span>
</span>
