@props([])

@php
    // basis-full shows one slide at a time. Override it through class for a
    // multi-up carousel, e.g. class="basis-1/2 md:basis-1/3".
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'min-w-0 shrink-0 grow-0 basis-full snap-start',
        $attributes->get('class'),
    );
@endphp

<div role="group" aria-roledescription="slide"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
