@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        '',
        $attributes->get('class'),
    );
@endphp

<li {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</li>
