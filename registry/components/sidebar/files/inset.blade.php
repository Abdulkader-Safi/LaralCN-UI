@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'relative flex min-h-svh flex-1 flex-col bg-background',
        $attributes->get('class'),
    );
@endphp

<main {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</main>
