@props([
    'side' => 'top',
])

@php
    // Hover and focus-within do the work, so this ships no script, the same
    // approach the tooltip takes.
    //
    // The gap between trigger and card is padding on the positioning wrapper,
    // never margin on the card. Margin would leave a dead strip that drops the
    // hover the moment the pointer sets off toward the card.
    $position = match ($side) {
        'bottom' => 'top-full left-1/2 -translate-x-1/2 pt-2',
        'left' => 'right-full top-1/2 -translate-y-1/2 pr-2',
        'right' => 'left-full top-1/2 -translate-y-1/2 pl-2',
        default => 'bottom-full left-1/2 -translate-x-1/2 pb-2',
    };

    // `block` is load-bearing: the card is a span (it has to be, the wrapper is
    // phrasing content) and width does nothing to an inline box. The wrapper
    // escapes this only because position:absolute blockifies it.
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'block w-64 rounded-md border bg-popover p-4 text-popover-foreground shadow-md',
        $attributes->get('class'),
    );
@endphp

<span class="group relative inline-flex" {{ $attributes->except('class') }}>
    {{ $trigger }}

    <span
        class="pointer-events-none invisible absolute z-50 opacity-0 transition-opacity delay-150 duration-200 group-hover:pointer-events-auto group-hover:visible group-hover:opacity-100 group-focus-within:pointer-events-auto group-focus-within:visible group-focus-within:opacity-100 {{ $position }}">
        <span role="dialog" class="{{ $classes }}">
            {{ $slot }}
        </span>
    </span>
</span>
