@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'inline-flex items-center gap-1.5',
        $attributes->get('class'),
    );
@endphp

<li {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</li>
