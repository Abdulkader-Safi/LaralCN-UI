@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'relative flex w-full min-w-0 flex-col p-2',
        $attributes->get('class'),
    );
@endphp

<div data-sidebar="group"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
