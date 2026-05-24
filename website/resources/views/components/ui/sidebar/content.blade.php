@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'flex min-h-0 flex-1 flex-col gap-2 overflow-auto group-data-[collapsible=icon]:overflow-hidden',
        $attributes->get('class'),
    );
@endphp

<div data-sidebar="content"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
