@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'absolute inset-y-0 z-20 hidden w-4 -translate-x-1/2 cursor-w-resize transition-all ease-linear after:absolute after:inset-y-0 after:left-1/2 after:w-[2px] hover:after:bg-sidebar-border group-data-[side=left]:-right-4 group-data-[side=right]:left-0 sm:flex',
        $attributes->get('class'),
    );
@endphp

<button type="button" aria-label="Toggle Sidebar" tabindex="-1"
    title="Toggle Sidebar" data-ui-sidebar-trigger
    {{ $attributes->except('class')->merge(['class' => $classes]) }}></button>
