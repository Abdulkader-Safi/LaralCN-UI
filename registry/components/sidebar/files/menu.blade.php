@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'flex w-full min-w-0 flex-col gap-1',
        $attributes->get('class'),
    );
@endphp

<ul data-sidebar="menu"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</ul>
