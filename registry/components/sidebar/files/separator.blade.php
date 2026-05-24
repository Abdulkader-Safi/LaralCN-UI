@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'mx-2 h-px w-auto shrink-0 bg-sidebar-border',
        $attributes->get('class'),
    );
@endphp

<div role="separator" aria-orientation="horizontal" data-sidebar="separator"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}></div>
