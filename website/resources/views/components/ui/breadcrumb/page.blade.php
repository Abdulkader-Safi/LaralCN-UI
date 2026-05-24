@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'font-normal text-foreground',
        $attributes->get('class'),
    );
@endphp

<span role="link" aria-disabled="true" aria-current="page"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
