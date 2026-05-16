@props([
    'orientation' => 'horizontal',
])

@php
    $base = $orientation === 'vertical' ? 'h-full w-px' : 'h-px w-full';

    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'shrink-0 bg-border',
        $base,
        $attributes->get('class'),
    );
@endphp

<div role="separator" aria-orientation="{{ $orientation }}"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}></div>
