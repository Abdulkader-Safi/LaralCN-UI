@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'mx-auto flex w-full justify-center',
        $attributes->get('class'),
    );
@endphp

<nav role="navigation" aria-label="pagination"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</nav>
