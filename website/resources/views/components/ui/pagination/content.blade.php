@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'flex flex-row items-center gap-1',
        $attributes->get('class'),
    );
@endphp

<ul {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</ul>
