@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'group/menu-item relative',
        $attributes->get('class'),
    );
@endphp

<li data-sidebar="menu-item"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</li>
