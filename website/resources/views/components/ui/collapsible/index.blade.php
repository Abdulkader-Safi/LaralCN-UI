@props([
    'open' => false,
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'group/collapsible',
        $attributes->get('class'),
    );
@endphp

<div x-data="{ open: @js((bool) $open) }"
    x-bind:data-state="open ? 'open' : 'closed'"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
