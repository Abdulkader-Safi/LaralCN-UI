@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'outline-none focus-visible:ring-ring/50 focus-visible:ring-[3px]',
        $attributes->get('class'),
    );
@endphp

<button type="button" @click="open = !open"
    x-bind:aria-expanded="open.toString()"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
