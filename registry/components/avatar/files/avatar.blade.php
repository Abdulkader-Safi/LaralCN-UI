@props([
    'src' => null,
    'alt' => '',
    'fallback' => null,
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full bg-muted',
        $attributes->get('class'),
    );
@endphp

<span {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $alt }}"
            class="aspect-square h-full w-full object-cover" />
    @else
        <span
            class="flex h-full w-full items-center justify-center text-sm font-medium text-muted-foreground"
            aria-hidden="true">
            {{ $fallback ?? $slot }}
        </span>
    @endif
</span>
