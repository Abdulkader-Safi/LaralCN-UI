@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70',
        $attributes->get('class'),
    );
@endphp

<label {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</label>
