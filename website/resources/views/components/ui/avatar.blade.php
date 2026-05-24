@props([
    'src' => null,
    'alt' => '',
    'fallback' => null,
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'relative flex size-8 shrink-0 overflow-hidden rounded-full',
        $attributes->get('class'),
    );
@endphp

<span {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $alt }}"
            class="aspect-square size-full object-cover" />
    @else
        <span
            class="flex size-full items-center justify-center rounded-full bg-muted text-sm font-medium text-muted-foreground"
            aria-hidden="true">
            {{ $fallback ?? $slot }}
        </span>
    @endif
</span>
