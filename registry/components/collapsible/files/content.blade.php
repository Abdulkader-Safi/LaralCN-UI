@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        '',
        $attributes->get('class'),
    );
@endphp

<div x-show="open" x-collapse x-cloak
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
