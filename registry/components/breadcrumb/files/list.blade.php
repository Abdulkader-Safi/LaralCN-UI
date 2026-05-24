@props([])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'flex flex-wrap items-center gap-1.5 break-words text-sm text-muted-foreground sm:gap-2.5',
        $attributes->get('class'),
    );
@endphp

<ol {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</ol>
