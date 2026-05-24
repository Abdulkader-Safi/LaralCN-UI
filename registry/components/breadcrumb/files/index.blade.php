@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        '',
        $attributes->get('class'),
    );
@endphp

<nav aria-label="breadcrumb"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</nav>
