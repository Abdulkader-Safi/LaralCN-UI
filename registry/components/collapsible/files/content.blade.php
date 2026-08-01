@props([])

@php
    // Hidden by default; <x-ui.collapsible :open="true"> flips it on via the
    // group-data-[state=open] rule its parent sets.
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'hidden group-data-[state=open]/collapsible:block',
        $attributes->get('class'),
    );
@endphp

<div data-ui-collapsible-content
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
