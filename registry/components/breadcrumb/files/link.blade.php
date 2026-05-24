@props([
    'href' => '#',
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'transition-colors hover:text-foreground',
        $attributes->get('class'),
    );
@endphp

<a href="{{ $href }}"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
