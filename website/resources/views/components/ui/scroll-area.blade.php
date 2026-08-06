@props([
    'orientation' => 'vertical',
])

@php
    // Native overflow does the scrolling, so there is no script and no
    // synthetic scrollbar to keep in sync. Give the element a height (or a
    // max-height) through `class`, otherwise there is nothing to scroll.
    $axis = match ($orientation) {
        'horizontal' => 'overflow-x-auto overflow-y-hidden',
        'both' => 'overflow-auto',
        default => 'overflow-y-auto overflow-x-hidden',
    };

    // Two separate systems, both needed. Firefox reads the standard
    // scrollbar-width / scrollbar-color properties; WebKit and Blink read the
    // ::-webkit-scrollbar pseudo-elements and ignore the standard ones.
    $firefox = '[scrollbar-width:thin] [scrollbar-color:var(--border)_transparent]';

    $webkit =
        '[&::-webkit-scrollbar]:size-2.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-border [&::-webkit-scrollbar-thumb:hover]:bg-muted-foreground/40 [&::-webkit-scrollbar-corner]:bg-transparent';

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'relative rounded-[inherit] focus-visible:ring-ring/50 focus-visible:ring-[3px] focus-visible:outline-none',
        $axis,
        $firefox,
        $webkit,
        $attributes->get('class'),
    );
@endphp

<div {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
