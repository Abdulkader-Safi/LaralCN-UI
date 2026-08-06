@props([
    'ratio' => '16/9',
])

@php
    $classes = \TailwindMerge\Laravel\Facades\TailwindMerge::merge(
        'relative w-full',
        $attributes->get('class'),
    );
@endphp

{{-- The ratio is an inline style on purpose. aspect-[{{ '$ratio' }}] would be
     built from a runtime value, and Tailwind only compiles classes it can find
     by scanning source files, so that class would never exist. --}}
<div style="aspect-ratio: {{ $ratio }}"
    {{ $attributes->except('class')->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
