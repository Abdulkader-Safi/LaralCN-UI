@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'w-full text-sm',
        $attributes->get('class'),
    );
@endphp

<div data-sidebar="group-content"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
