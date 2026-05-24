@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'group/menu-sub-item relative',
        $attributes->get('class'),
    );
@endphp

<li data-sidebar="menu-sub-item"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</li>
